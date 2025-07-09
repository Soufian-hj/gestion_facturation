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
        .header { text-align: center; margin-bottom: 10px; }
        .orange { background: #ff9800; color: #fff; }
        .gray { background: #f5f5f5; }
    </style>
</head>
<body>
    <table style="width: 100%;">
        <tr>
            <td style="width: 120px; vertical-align: top;">
                <img src="{{ public_path('assets/logo.png') }}" alt="Logo" class="logo">
            </td>
            <td class="header">
                <h2 style="margin-bottom: 0;">STE MTS SMART SARL</h2>
                <div style="font-size: 13px;">Négoce, Import-export<br>Entretien, maintenance et installation de tout type de matériel</div>
            </td>
        </tr>
    </table>
    <hr>
    <h2 style="text-align: center; color: #ff9800; margin: 10px 0;">Devis</h2>
    <table style="width: 100%; margin-bottom: 10px;">
        <tr>
            <td><strong>Date :</strong> {{ $devis->date }}</td>
            <td><strong>Client :</strong> {{ $devis->client->nom ?? '' }}</td>
            <td><strong>État :</strong> {{ $devis->etat ?? 'En attente' }}</td>
        </tr>
        <tr>
            <td><strong>N° :</strong> D-{{ date('Y') }}-{{ $devis->id }}</td>
            <td><strong>Code Client :</strong> {{ $devis->client_id }}</td>
            <td><strong>TVA Client :</strong></td>
        </tr>
    </table>
    <table class="table">
        <thead class="orange">
            <tr>
                <th>Réf</th>
                <th>Désignation</th>
                <th>Unité</th>
                <th>Quantité</th>
                <th>PU HT</th>
                <th>PU TTC</th>
                <th>Total HT</th>
                <th>Total TTC</th>
                <th>Taxe</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalHT = 0;
                $totalTTC = 0;
            @endphp
            @foreach ($devis->lignes as $index => $ligne)
                @php
                    $pu_ht = $ligne->prix_unitaire;
                    $pu_ttc = $pu_ht * 1.2;
                    $total_ligne_ht = $ligne->total();
                    $total_ligne_ttc = $pu_ttc * $ligne->quantite;
                    $totalHT += $total_ligne_ht;
                    $totalTTC += $total_ligne_ttc;
                @endphp
                <tr class="gray">
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $ligne->produit->nom ?? '' }}</td>
                    <td>1,00</td>
                    <td class="text-right">{{ $ligne->quantite }}</td>
                    <td class="text-right">{{ number_format($pu_ht, 2) }}</td>
                    <td class="text-right">{{ number_format($pu_ttc, 2) }}</td>
                    <td class="text-right">{{ number_format($total_ligne_ht, 2) }}</td>
                    <td class="text-right">{{ number_format($total_ligne_ttc, 2) }}</td>
                    <td>TVA 20%</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <br>
    @php
        $tva = $totalHT * 0.20;
    @endphp
    <table style="width: 100%;">
        <tr>
            <td style="width: 70%;"></td>
            <td>
                <table>
                    <tr>
                        <td><strong>Total HT :</strong></td>
                        <td class="text-right">{{ number_format($totalHT, 2) }} MAD</td>
                    </tr>
                    <tr>
                        <td><strong>TVA 20% :</strong></td>
                        <td class="text-right">{{ number_format($tva, 2) }} MAD</td>
                    </tr>
                    <tr>
                        <td><strong>Total TTC :</strong></td>
                        <td class="text-right">{{ number_format($totalTTC, 2) }} MAD</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <br><br>
    <p><em>Net à payer : {{ number_format($totalTTC, 2) }} MAD</em></p>
    <hr>
    <p style="font-size: 10px; text-align: center;">
        STE MTS SMART SARL - RC : 16163 - Tél : 06 66 90 78 39 - Email : ste.mtsmart@gmail.com
    </p>
</body>
</html> 