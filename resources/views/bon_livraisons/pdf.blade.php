<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bon de Livraison #{{ $bonLivraison->idBL }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 13px; color: #222; }
        .header { text-align: center; margin-bottom: 10px; }
        .logo { width: 120px; margin-bottom: 8px; }
        .societe { font-size: 18px; font-weight: bold; color: #2563eb; }
        .slogan { font-size: 12px; color: #666; margin-bottom: 8px; }
        .box { border: 1px solid #222; border-radius: 8px; padding: 10px; margin-bottom: 18px; }
        .title { font-size: 18px; font-weight: bold; color: #222; margin-bottom: 8px; }
        .info-table { width: 100%; margin-bottom: 10px; }
        .info-table td { padding: 2px 6px; font-size: 13px; }
        .bl-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .bl-table th, .bl-table td { border: 1px solid #000; padding: 5px; font-size: 14px; }
        .bl-table th { background: #ff9800; color: #fff; font-weight: bold; text-align: center; }
        .bl-table tr.gray { background: #f5f5f5; }
        .bl-table td { vertical-align: top; }
        .signatures { width: 100%; margin-top: 60px; }
        .signatures td { width: 33%; text-align: center; font-size: 12px; height: 60px; vertical-align: bottom; }
        .footer { font-size: 10px; color: #888; text-align: center; margin-top: 30px; }
    </style>
</head>
<body>
    <table style="width: 100%; margin-bottom: 10px;">
        <tr>
            <td style="width: 120px; vertical-align: top;">
                <img src="{{ public_path('assets/logo.png') }}" alt="Logo" style="width: 100px;">
            </td>
            <td style="text-align: center;">
                <div style="font-size: 26px; font-weight: bold; letter-spacing: 1px; margin-bottom: 2px;">STE MTS SMART SARL</div>
                <div style="font-size: 15px; color: #444;">Négoce, Import-export</div>
                <div style="font-size: 15px; color: #222;">Entretien, maintenance et installation de tout type de matériel</div>
            </td>
        </tr>
    </table>
    <hr style="border: 2px solid #888; margin-bottom: 18px;">
    <div class="box">
        <div class="title">BON DE LIVRAISON N° {{ $bonLivraison->numeroBL ?? $bonLivraison->idBL }}/{{ date('Y', strtotime($bonLivraison->date)) }}</div>
        <table class="info-table">
            <tr>
                <td><b>Client :</b></td>
                <td>{{ $bonLivraison->client->nom ?? '-' }}</td>
            </tr>
            <tr>
                <td><b>Date :</b></td>
                <td>{{ date('d/m/Y', strtotime($bonLivraison->date)) }}</td>
            </tr>
        </table>
    </div>
    <table class="bl-table">
        <thead>
            <tr>
                <th style="width:70%;">Désignation</th>
                <th style="width:15%;">Unité</th>
                <th style="width:15%;">Q</th>
            </tr>
        </thead>
        <tbody>
        @php
            $lignes = $bonLivraison->devi && $bonLivraison->devi->lignes ? $bonLivraison->devi->lignes : collect();
        @endphp
        @forelse($lignes as $i => $ligne)
            <tr class="{{ $i % 2 === 1 ? 'gray' : '' }}">
                <td>
                    {{ $ligne->produit->nom ?? '-' }}
                    @if($ligne->produit && $ligne->produit->description)
                        <br>
                        <span style="font-size:12px;color:#444;">{!! nl2br(e($ligne->produit->description)) !!}</span>
                    @endif
                </td>
                <td style="text-align:center;">{{ $ligne->unite ?? 'U' }}</td>
                <td style="text-align:center;">{{ $ligne->quantite ?? 1 }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="3" style="text-align:center; color:#888;">Aucun produit dans le devis</td>
            </tr>
        @endforelse
        <!-- Ligne vide automatique supprimée -->
        </tbody>
    </table>
    <table class="signatures">
        <tr>
            <td>signature</td>
            <td></td>
            <td>STE MTS SMART SARL</td>
        </tr>
    </table>
    <div style="text-align:right; font-size:12px; margin-top:10px;">
        Béni Mellal, le {{ date('d-m-Y', strtotime($bonLivraison->date)) }}
    </div>
    <div style="height: 170px;"></div>
    <div class="footer">
        PATENTE : 41930821 - ICE : 00673703000065 - IF : 16219684 - RC : 15163<br>
        Tel : 06 96 06 96 73/39 - E-mail : ste.mtsmart@gmail.com - A/R : 00790040608300010008910<br>
        SIEGE SOCIAL : DOM-CHEZ STE RIDATHA IMM.B6 APT 14B BD MOHAMED V Beni Mellal
    </div>
</body>
</html> 