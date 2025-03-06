<!DOCTYPE html>
<html>
<head>
    <title>Rapport des Ventes</title>
</head>
<body>
    <h1>Rapport des Ventes</h1>
    <table border="1">
        <tr>
            <th>Produit</th>
            <th>Ventes</th>
            <th>Prédiction</th>
        </tr>
        @foreach($sales as $sale)
        <tr>
            <td>{{ $sale->product_name }}</td> <!-- Afficher le nom du produit -->
            <td>{{ $sale->total_sales }}</td>
            <td>{{ $sale->predicted_sales }}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>
