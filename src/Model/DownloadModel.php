<?php
namespace App\Model;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Validator\Constraints\DateTime;
use Doctrine\ORM\EntityManager;


use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

// Include Dompdf required namespaces
use Dompdf\Dompdf;
use Dompdf\Options;

// Include PhpSpreadsheet required namespaces
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class DownloadModel
{

        private $container;
        private $entityManager;
        private $templating;
        
        
        public function __construct( ContainerInterface $container, EntityManager $entityManager, \Twig\Environment $templating ) {
            $this->container = $container;
            $this->entityManager = $entityManager;
            $this->templating = $templating;
        }
        function downloadFile($fileType, $resAll){
            
            
            $res = [];
            
            $_type = 'pdf';
            $downloadFiles = ['pdf', 'csv', 'excel'];
            if( in_array($fileType, $downloadFiles ) )
                    $_type = $fileType;
            
            
            
            
            try {
                
                $adapter = new DoctrineORMAdapter($resAll);

                $pagerfanta = new Pagerfanta($adapter);
                $pagerfanta->setMaxPerPage(1000);
                $pagerfanta->setCurrentPage(1);

                $totalCount = $pagerfanta->getNbResults();


                $results = array();
                
                $results[] = array(
                    'title' => $this->container->get('translator')->trans('title.title',[],'messages'), 
                    'comment' => $this->container->get('translator')->trans('title.comment',[],'messages'), 
                    'dateAt' => $this->container->get('translator')->trans('title.date',[],'messages'), 
                    'timespent' => $this->container->get('translator')->trans('title.spent',[],'messages')
                );
                
                
                $totalTime = 0;
                foreach( $pagerfanta->getCurrentPageResults() as $res ){  
                    $results[] = array(
                        //'id' => $res['tid'],
                        'title' => $res['ttitle'],
                        'comment' => $res['tcomment'],
                        'dateAt' => $res['tdateAt']->format('Y-m-d'),
                        'timespent' => $res['ttimespent'],
                    );
                    if(is_numeric($res['ttimespent']) )
                    $totalTime += (int)$res['ttimespent'];
                }
                
                
                $res['filename'] = $_type.'.';
                if( $_type=='pdf' ){
                    $res['fileContent'] = $this->generatePdf($results, $totalTime);
                    $res['filename'] .= 'pdf';
                }
                elseif( $_type=='excel'  ){
                    $res['fileContent'] = $this->generateExcel($results, $totalTime);
                    $res['filename'] .= 'xlsx';
                }
                else{
                    $res['fileContent'] = $this->generateCsv($results, $totalTime);
                    $res['filename'] .= 'csv';
                }
                /*
                echo "<pre>";
                print_r( $res );
                echo "</pre>";
                die;*/
                
            } catch (\Exception $e) {
                echo $e->getMessage();
            }
            
            return $res;
        }
        private function generateExcel($results, $totalTime){
            $spreadsheet = new Spreadsheet();
        
            /* @var $sheet \PhpOffice\PhpSpreadsheet\Writer\Xlsx\Worksheet */
            $sheet = $spreadsheet->getActiveSheet();
            
            
            //$data .= implode(",", [
            //    'Title', 'Comment', 'Date', 'Time spent(minutes)'
            //]) .PHP_EOL;
            
            foreach($results as $key => $arr) {
                //foreach( $arr as $k1=>$v1 ){
                    //$arr[$k1] = addslashes($v1);
                    $sheet->setCellValue('A'. (string)($key + 1), $arr['title'] );
                    $sheet->setCellValue('B'. (string)($key + 1), $arr['comment'] );
                    $sheet->setCellValue('C'. (string)($key + 1), $arr['dateAt'] );
                    $sheet->setCellValue('D'. (string)($key + 1), $arr['timespent'] );
                //}
                //$data .= implode(",", $arr) .PHP_EOL;
            }
            $sheet->setCellValue('D'. (string)(count($results) + 1), $totalTime );
            
            
            
            
            $sheet->setTitle("My Tasks");

            // Create your Office 2007 Excel (XLSX Format)
            $writer = new Xlsx($spreadsheet);

            // Create a Temporary file in the system
            $fileName = 'symfony4.xlsx';
            $temp_file = tempnam(sys_get_temp_dir(), $fileName);

            // Create the excel file in the tmp directory of the system
            $writer->save($temp_file);
            
            
            return  file_get_contents($temp_file);
        }
        private function generatePdf($results, $totalTime){
            $data = '';
            
            
           // Configure Dompdf according to your needs
            $pdfOptions = new Options();
            $pdfOptions->set('defaultFont', 'Arial');

            // Instantiate Dompdf with our options
            $dompdf = new Dompdf($pdfOptions);

            // Retrieve the HTML generated in our twig file
            $html = $this->templating->render('others/mypdf.html.twig', [
                'tasks' => $results,
                'totalTime' => $totalTime
            ]);

            
            
            
            // Load HTML to Dompdf
            $dompdf->loadHtml($html);

            // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
            $dompdf->setPaper('A4', 'portrait');

            // Render the HTML as PDF
            $dompdf->render();

            // Store PDF Binary Data
            $data = $dompdf->output();
            



            return $data;
        }
        private function generateCsv($results, $totalTime){
            $data = '';
            
            /*
            $data .= implode(",", [
                'Title', 'Comment', 'Date', 'Time spent(minutes)'
            ]) .PHP_EOL;
            */
            foreach($results as $key => $arr) {
                foreach( $arr as $k1=>$v1 ){
                    $arr[$k1] = addslashes($v1);
                }
                $data .= implode(",", $arr) .PHP_EOL;
            }
            $data .= implode(",", [
                '', '', '', $totalTime
            ]) .PHP_EOL;
            



            return $data;
        }
}