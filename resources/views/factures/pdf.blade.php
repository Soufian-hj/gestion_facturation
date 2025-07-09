<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>



body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { border: 1px solid #000; padding: 4px; }
        .text-right { text-align: right; }
        .bold { font-weight: bold; }
        .logo { width: 100px; }
    </style>
</head>
<body>
    <table style="width: 100%;">
        <tr>
            <td style="width: 120px; vertical-align: top;">
                <img src="{{ public_path('assets/logo.png') }}" alt="Logo" class="logo">
            </td>
            <td style="text-align: center;">
                <h2 style="margin-bottom: 0;">STE MTS SMART SARL</h2>
                <div style="font-size: 13px;">Négoce, Import-export<br>Entretien, maintenance et installation de tout type de matériel</div>
            </td>
        </tr>
    </table>
    <hr>

    <p><strong>Facture N° :</strong> F-{{ date('Y') }}-{{ $facture->id }}</p>
    <p><strong>Date :</strong> {{ $facture->date }}</p>
    <p><strong>Client :</strong> {{ $facture->client->nom }}</p>
    <p><strong>ICE :</strong> {{ $facture->client->ice ?? 'N/A' }}</p>

    <br>

    <table class="table">
        <thead>
            <tr>
                <th>Réf</th>
                <th>Désignation</th>
                <th>Quantité</th>
                <th>PU HT</th>
                <th>Total HT</th>
                <th>TVA</th>
                <th>Total TTC</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($facture->lignes as $index => $ligne)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $ligne->produit->nom }}</td>
                    <td class="text-right">{{ $ligne->quantite }}</td>
                    <td class="text-right">{{ number_format($ligne->produit->prix_unitaire, 2) }}</td>
                    <td class="text-right">{{ number_format($ligne->produit->prix_unitaire * $ligne->quantite, 2) }}</td>
                    <td class="text-right">20%</td>
                    <td class="text-right">{{ number_format($ligne->prix_total, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <br>

    <table style="width: 100%;">
        <tr>
            <td style="width: 70%;"></td>
            <td>
                <table>
                    <tr>
                        <td><strong>Total HT :</strong></td>
                        <td class="text-right">{{ number_format($facture->lignes->sum(fn($l) => $l->produit->prix_unitaire * $l->quantite), 2) }} MAD</td>
                    </tr>
                    <tr>
                        <td><strong>TVA 20% :</strong></td>
                        <td class="text-right">{{ number_format($facture->lignes->sum('prix_total') - $facture->lignes->sum(fn($l) => $l->produit->prix_unitaire * $l->quantite), 2) }} MAD</td>
                    </tr>
                    <tr>
                        <td><strong>Total TTC :</strong></td>
                        <td class="text-right">{{ number_format($facture->lignes->sum('prix_total'), 2) }} MAD</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <br><br>
    <p><em>Net à payer : {{ number_format($facture->lignes->sum('prix_total'), 2) }} MAD</em></p>

    <hr>
    <p style="font-size: 10px; text-align: center;">
        STE MTS SMART SARL - RC : 16163 - Tél : 06 66 90 78 39 - Email : ste.mtsmart@gmail.com
    </p>

</body>
</html>
