<?php
// ============================================
// controllers/PdfController.php
// Génération de factures PDF
// ============================================

require_once __DIR__ . '/../vendor/autoload.php';
require_once 'config/db.php';
require_once 'models/Order.php';

function genererFacturePDF() {

    // Vérifie que l'utilisateur est connecté
    if (!isset($_SESSION['user_id'])) {
        header('Location: /ShopESA/?page=connexion');
        exit;
    }

    $user_id  = $_SESSION['user_id'];
    $order_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    // Récupère le détail de la commande
    $detail = getCommandeDetail($order_id, $user_id);

    if (empty($detail)) {
        header('Location: /ShopESA/?page=historique');
        exit;
    }

    $commande = $detail[0];

    // Calcul des totaux
    $total_ttc = $commande['total'];
    $total_ht  = $total_ttc / 1.18;
    $tva       = $total_ttc - $total_ht;

    // Création du PDF
    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8');

    // Métadonnées
    $pdf->SetCreator('ShopESA');
    $pdf->SetAuthor('ShopESA — ESA-AGOE');
    $pdf->SetTitle('Facture #' . $order_id);

    // Pas d'en-tête/pied de page automatique
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);

    // Marges
    $pdf->SetMargins(15, 15, 15);
    $pdf->AddPage();

    // ── EN-TÊTE ──────────────────────────────
    $pdf->SetFillColor(44, 62, 80);
    $pdf->Rect(0, 0, 210, 40, 'F');

    $pdf->SetTextColor(255, 255, 255);
    $pdf->SetFont('helvetica', 'B', 24);
    $pdf->SetXY(15, 10);
    $pdf->Cell(0, 10, 'ShopESA', 0, 1, 'L');

    $pdf->SetFont('helvetica', '', 11);
    $pdf->SetXY(15, 22);
    $pdf->Cell(0, 8, 'ESA-AGOE — Licence 2 Informatique', 0, 1, 'L');

    // Numéro facture à droite
    $pdf->SetFont('helvetica', 'B', 14);
    $pdf->SetXY(120, 10);
    $pdf->Cell(75, 8, 'FACTURE #' . $order_id, 0, 1, 'R');

    $pdf->SetFont('helvetica', '', 10);
    $pdf->SetXY(120, 20);
    $pdf->Cell(75, 8, 'Date : ' . date('d/m/Y', strtotime($commande['created_at'])), 0, 1, 'R');

    // ── INFOS CLIENT ─────────────────────────
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetXY(15, 50);

    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->SetFillColor(240, 240, 240);
    $pdf->Cell(180, 8, 'INFORMATIONS CLIENT', 0, 1, 'L', true);

    $pdf->SetFont('helvetica', '', 10);
    $pdf->SetX(15);

    // Parse l'adresse
    $adresse_lines = explode("\n", $commande['adresse']);
    $nom_livraison = $adresse_lines[0] ?? $_SESSION['user_nom'];
    $telephone     = $adresse_lines[1] ?? '';
    $adresse       = $adresse_lines[2] ?? '';
    $ville         = $adresse_lines[3] ?? '';

    $pdf->Ln(2);
    $pdf->SetX(15);
    $pdf->Cell(90, 7, 'Nom : ' . $nom_livraison, 0, 0, 'L');
    $pdf->Cell(90, 7, 'Téléphone : ' . $telephone, 0, 1, 'L');
    $pdf->SetX(15);
    $pdf->Cell(90, 7, 'Adresse : ' . $adresse, 0, 0, 'L');
    $pdf->Cell(90, 7, 'Ville : ' . $ville, 0, 1, 'L');

    // Statut commande
    $statuts = [
        'en_attente' => 'En attente',
        'expediee'   => 'Expédiée',
        'livree'     => 'Livrée'
    ];
    $pdf->SetX(15);
    $pdf->Cell(180, 7, 'Statut : ' . ($statuts[$commande['statut']] ?? $commande['statut']), 0, 1, 'L');

    // ── TABLEAU DES ARTICLES ──────────────────
    $pdf->Ln(5);
    $pdf->SetFont('helvetica', 'B', 11);
    $pdf->SetFillColor(44, 62, 80);
    $pdf->SetTextColor(255, 255, 255);

    $pdf->Cell(80, 9, 'Produit', 1, 0, 'C', true);
    $pdf->Cell(30, 9, 'Quantité', 1, 0, 'C', true);
    $pdf->Cell(35, 9, 'Prix unitaire', 1, 0, 'C', true);
    $pdf->Cell(35, 9, 'Sous-total', 1, 1, 'C', true);

    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('helvetica', '', 10);

    $fill = false;
    foreach ($detail as $item) {
        $pdf->SetFillColor(248, 248, 248);
        $sous_total = $item['quantite'] * $item['prix_unit'];

        $pdf->Cell(80, 8, $item['produit_nom'], 1, 0, 'L', $fill);
        $pdf->Cell(30, 8, $item['quantite'], 1, 0, 'C', $fill);
        $pdf->Cell(35, 8, number_format($item['prix_unit'], 0, ',', ' ') . ' FCFA', 1, 0, 'R', $fill);
        $pdf->Cell(35, 8, number_format($sous_total, 0, ',', ' ') . ' FCFA', 1, 1, 'R', $fill);
        $fill = !$fill;
    }

    // ── TOTAUX ───────────────────────────────
    $pdf->Ln(3);
    $pdf->SetFont('helvetica', '', 10);

    $pdf->SetX(110);
    $pdf->Cell(45, 7, 'Sous-total HT :', 0, 0, 'R');
    $pdf->Cell(35, 7, number_format($total_ht, 0, ',', ' ') . ' FCFA', 0, 1, 'R');

    $pdf->SetX(110);
    $pdf->Cell(45, 7, 'TVA (18%) :', 0, 0, 'R');
    $pdf->Cell(35, 7, number_format($tva, 0, ',', ' ') . ' FCFA', 0, 1, 'R');

    // Total TTC en gras
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->SetFillColor(44, 62, 80);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->SetX(110);
    $pdf->Cell(45, 10, 'TOTAL TTC :', 0, 0, 'R', true);
    $pdf->Cell(35, 10, number_format($total_ttc, 0, ',', ' ') . ' FCFA', 0, 1, 'R', true);

    // ── PIED DE PAGE ─────────────────────────
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('helvetica', 'I', 9);
    $pdf->SetY(-30);
    $pdf->SetFillColor(240, 240, 240);
    $pdf->Cell(180, 8, 'Merci pour votre achat sur ShopESA — ESA-AGOE Licence 2 Informatique 2024-2025', 0, 1, 'C', true);
    $pdf->Cell(180, 6, 'Document généré le ' . date('d/m/Y à H:i'), 0, 1, 'C');

    // Télécharge le PDF
    $pdf->Output('Facture_ShopESA_' . $order_id . '.pdf', 'D');
    exit;
}
