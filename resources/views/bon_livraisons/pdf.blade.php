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
        .objet { font-size: 13px; margin-bottom: 10px; }
        .box { border: 1px solid #222; border-radius: 8px; padding: 10px; margin-bottom: 18px; }
        .title { font-size: 18px; font-weight: bold; color: #222; margin-bottom: 8px; }
        .info-table { width: 100%; margin-bottom: 10px; }
        .info-table td { padding: 2px 6px; font-size: 13px; }
        .bl-table { width: 100%; border-collapse: collapse; margin-bottom: 18px; }
        .bl-table th, .bl-table td { border: 1px solid #222; padding: 6px 4px; font-size: 12px; }
        .bl-table th { background: #f3f4f6; font-weight: bold; text-align: center; }
        .bl-table td { vertical-align: top; }
        .signatures { width: 100%; margin-top: 40px; }
        .signatures td { width: 33%; text-align: center; font-size: 12px; height: 60px; vertical-align: bottom; }
        .footer { font-size: 10px; color: #888; text-align: center; margin-top: 30px; }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('assets/logo.png') }}" class="logo" alt="Logo">
        <div class="societe">STE MTS SMART SARL</div>
        <div class="slogan">Négoce, Import-Export, Installation, Formation, Entretien, Maintenance, Réparation</div>
    </div>
    <div class="box">
        <div class="title">BON DE LIVRAISON N° {{ $bonLivraison->numeroBL ?? $bonLivraison->idBL }}/{{ date('Y', strtotime($bonLivraison->date)) }}</div>
        <table class="info-table">
            <tr>
                <td><b>Client :</b></td>
                <td>{{ $bonLivraison->client->nom ?? '-' }}</td>
            </tr>
            <tr>
                <td><b>Date :</b></td>
                <td>{{ $bonLivraison->date }}</td>
            </tr>
            <tr>
                <td><b>Objet :</b></td>
                <td>ACHAT DE MATERIEL INFORMATIQUE (Station de travail mobile) POUR FORMATION INFORMATIQUE dans le cadre de la Formation Continue</td>
            </tr>
        </table>
    </div>
    <table class="bl-table">
        <thead>
            <tr>
                <th>Désignation</th>
                <th>Unité</th>
                <th>Q</th>
            </tr>
        </thead>
        <tbody>
        @forelse($bonLivraison->lignes as $ligne)
            <tr>
                <td>{{ $ligne->designation ?? $ligne->produit->nom ?? '-' }}<br>
                    @if($ligne->produit && $ligne->produit->description)
                        <span style="font-size:11px;color:#666;">{{ $ligne->produit->description }}</span>
                    @endif
                </td>
                <td style="text-align:center;">{{ $ligne->unite ?? 'U' }}</td>
                <td style="text-align:center;">{{ $ligne->quantite ?? 1 }}</td>
            </tr>
        @empty
            <tr><td colspan="3" style="text-align:center; color:#888;">Aucune ligne</td></tr>
        @endforelse
        </tbody>
    </table>
    <table class="signatures">
        <tr>
            <td>FACULTE DES SCIENCES ET TECHNIQUES BENI MELLAL</td>
            <td></td>
            <td>STE MTS SMART SARL</td>
        </tr>
    </table>
    <div style="text-align:right; font-size:12px; margin-top:10px;">Beni Mellal, le {{ date('d-m-Y', strtotime($bonLivraison->date)) }}</div>
    <div class="footer">
        PATENTE : 41930821 - ICE : 00673703000065 - IF : 16219684 - RC : 15163<br>
        Tel : 06 96 06 96 73/39 - E-mail : ste.mtsmart@gmail.com - A/R : 00790040608300010008910<br>
        SIEGE SOCIAL : DOM-CHEZ STE RIDATHA IMM.B6 APT 14B BD MOHAMED V Beni Mellal
    </div>
</body>
</html> 