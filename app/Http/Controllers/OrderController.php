<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            // Récupérer le client
            $customer = Customer::find($request->customer_id);
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
                'customer_id' => $request->customer_id,
                'total' => $finalTotal, // Utiliser le total après réduction
            ]);

            // Créer les items de la commande (produits achetés)
            $orderItems = collect($request->items)->mapWithKeys(function ($item) {
                return [
                    $item['product_id'] => [
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                    ]
                ];
            });

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
