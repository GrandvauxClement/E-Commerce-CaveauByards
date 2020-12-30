<?php

namespace App\Controller\Pdf;

use App\Repository\OrderDetailsRepository;
use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Twig\Environment;

class PdfFilesController extends AbstractController
{
    /**
     * @Route("/commande/pdfView/{id}", name="facturePdf")
     */
    public function TestPdfFacture(int $id, OrderRepository $orderRepository, OrderDetailsRepository $orderDetailsRepository, ParameterBagInterface $parameterBag):Response
    {
        $order = $orderRepository->find($id);
        $orderDetailsAll = $orderDetailsRepository->findBy(['commande' => $order->getId()]);

        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $pdfOptions->setIsRemoteEnabled(true);
        $pdfOptions->setChroot('C:\Users\cleme\OneDrive\Bureau\MON ENTREPRISE\projet\e-commerce\eCommerceCaveauByards\public');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        $context = stream_context_create([
            'ssl' => [
                'verify_peer' => FALSE,
                'verify_peer_name' => FALSE,
                'allow_self_signed'=> TRUE
            ]
        ]);
        $dompdf->setHttpContext($context);

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('pdf/facture-pdf.html.twig', [
            'order' => $order,
            'orderDetail' => $orderDetailsAll,
            ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);


        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
      //  $dompdf->stream("mypdf.pdf", ["Attachment" => false]);

        // Store PDF Binary Data
        $output = $dompdf->output();
        $publicDirectory = $parameterBag->get('kernel.project_dir') . '/public';
        // e.g /var/www/project/public/mypdf.pdf
        $pdfFilepath =  $publicDirectory . '/pdf/facture/facture' . $order->getId() . '.pdf';

        // Write file to the desired path
        file_put_contents($pdfFilepath, $output);

        return $this->render('pdf/facture-pdf.html.twig', [
            'order' => $order,
            'orderDetail' => $orderDetailsAll,

        ]);

    }
}