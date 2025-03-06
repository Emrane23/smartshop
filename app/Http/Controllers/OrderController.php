<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{

    public function store(Request $request)
    {
        DB::beginTransaction();
    
        try {
            // Récupérer le client
            $customer = Customer::findOrFail($request->customer_id);
            $discount = 0;
    
            // Vérifier si le client a plus de 100 points pour appliquer une réduction
            if ($customer->points >= 100) {
                $discount = 10; // Réduction de 10 dinars pour 100 points
                $customer->decrement('points', 100); // Soustraire les points
            }
    
            // Calculer le total final après application de la réduction
            $finalTotal = max($request->total - $discount, 0);
    
            // Créer la commande
            $order = Order::create([
                'customer_id' => $customer->id,
                'total' => $finalTotal, // Utiliser le total après réduction
            ]);
    
            // Récupérer les produits à partir de la base de données en une seule requête
            $productIds = collect($request->items)->pluck('product_id');
            $products = Product::whereIn('id', $productIds)->get()->keyBy('id');
    
            // Créer les items de la commande (produits achetés)
            $orderItems = [];
            foreach ($request->items as $item) {
                $product = $products->get($item['product_id']);
                
                // Vérifier si le stock est suffisant
                if ($product->stock >= $item['quantity']) {
                    // Ajouter l'item à la commande
                    $orderItems[$item['product_id']] = [
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                    ];
                    
                    // Décrémenter le stock du produit
                    $product->decrement('stock', $item['quantity']);
                } else {
                    throw new \Exception("Le produit {$product->name} n'a pas assez de stock.");
                }
            }
    
            // Ajouter les produits à la commande
            $order->products()->attach($orderItems);
    
            // Ajouter des points sur le montant final (1 point par 10 dinars dépensés)
            $pointsEarned = floor($finalTotal / 10);
            $customer->increment('points', $pointsEarned);
    
            // Commit de la transaction
            DB::commit();
    
            return response()->json([
                'message' => 'Commande passée avec succès',
                'total_final' => $finalTotal,
                'points_gagnés' => $pointsEarned,
            ]);
    
        } catch (\Exception $e) {
            // Rollback en cas d'erreur
            DB::rollBack();
    
            return response()->json([
                'message' => 'Erreur lors du passage de la commande',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    
}
