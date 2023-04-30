<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Article;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

class ArticleController extends AbstractController
{ 
    //Basic endpoints
    #[Route('/article', name: 'create_article', methods: ['POST', 'HEAD'])]
    public function createArticle( Request $request, EntityManagerInterface $entityManager ): JsonResponse
    {
        $arrayData = json_decode( $request->getContent(), true );

        $oArticle = new Article();
        $oArticle->setTitle( $arrayData['title'] );
        $oArticle->setContent( $arrayData['content'] );  
        $oArticle->setCreatedAt( new DateTime( $arrayData['created_at']) );
        $oArticle->setPublishAt( new DateTime( $arrayData['publish_at']) );
        $oArticle->setStatus( $arrayData['status'] );

        $entityManager->persist( $oArticle );
        $entityManager->flush();

        return $this->json('Article created successfully.');
    }

    #[Route('/articles', name: 'list_articles', methods: ['GET', 'HEAD'])]
    public function listAllArticles(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer ): Response
    {
        $date = $request->query->get('created');
       
        $arrayArticles = $entityManager->getRepository( Article::class )->findAll();
    
        $oResponse = new Response();
        $arrArticlesData = [];

        foreach ( $arrayArticles as $oArticle ) {
            $arrArticlesData[] = [
                'id'         => $oArticle->getId(),
                'title'      => $oArticle->getTitle(),
                'content'    => $oArticle->getContent(),
                'created_at' => $this->formatDate( $oArticle->getCreatedAt(), $serializer ),
                'publish_at' => $this->formatDate( $oArticle->getPublishAt(), $serializer ),
                'status'     => $oArticle->getStatus(),
            ];
        }

        $jsonArrData = json_encode( $arrArticlesData, JSON_UNESCAPED_UNICODE  );
        return $oResponse->setContent( $jsonArrData );
    }

    private function formatDate( $date,  $serializer ) {
        $dateSerialized = $serializer->serialize( $date, JsonEncoder::FORMAT,[DateTimeNormalizer::FORMAT_KEY => 'Y-m-d H:i:s'] );
        $dateSerialized = ltrim( $dateSerialized, '\"' );
        $dateSerialized = rtrim( $dateSerialized, '\"' );
        return $dateSerialized;
    }

    //Additional endpoints
    #[Route('/active-articles', name: 'list_active_articles', methods: ['GET', 'HEAD'])]
    public function listAllActiveArticles(EntityManagerInterface $entityManager, SerializerInterface $serializer): Response
    {
        $arrArticles = $entityManager->getRepository(Article::class)->findBy( ['status' => 'active'] );

        $arrArticleData = [];

        foreach ( $arrArticles as $oArticle ) { 
            $arrArticleData[] = [
                'id'         => $oArticle->getId(),
                'title'      => $oArticle->getTitle(),
                'content'    => $oArticle->getContent(),
                'created_at' => $this->formatDate( $oArticle->getCreatedAt(), $serializer ),
                'publish_at' => $this->formatDate( $oArticle->getPublishAt(), $serializer ),
                'status'     => $oArticle->getStatus(),
            ];
        }

        $jsonArrData = json_encode( $arrArticleData, JSON_UNESCAPED_UNICODE );
        $oResponse = new Response();
        $oResponse->setContent( $jsonArrData );
        return $oResponse;
    }

 
    #[Route('/articles/{id}/CSV', name: 'show_article_csv', methods: ['GET', 'HEAD'])] //CSV format/single article
    public function showArticleCSV(Article $article): Response
    {
        $arrayData = [
            ['ID', 'Title', 'Content', 'Status'],
            [$article->getId(), $article->getTitle(), $article->getContent(), $article->getStatus()],
        ];

        $oResponse = new Response();
        $oResponse->headers->set('Content-Type', 'text/csv');
        $oResponse->headers->set('Content-Disposition', 'attachment; filename="article.csv"');
        return $oResponse->setContent( $this->arrayToCsv( $arrayData ) );
    }

    private function arrayToCsv(array $data): string
    {
        $outputBuffer = fopen('php://temp', 'w');
        foreach ( $data as $row ) {
            fputcsv( $outputBuffer, $row );
        }
        rewind( $outputBuffer );
        $csv = stream_get_contents( $outputBuffer );
        fclose( $outputBuffer );
        return $csv;
    }

    #[Route('/articles-additional', name: 'list_articles_additional', methods: ['GET', 'HEAD'])]
    public function listAllArticlesAdditional(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer ): Response
    {
        $date = $request->query->get('created');
        if ( $date == null ){
            $arrayArticles = $entityManager->getRepository( Article::class )->findAll(); //array of objects
        }
        else {
            $startDate = $date . ' 00:00:00';
            $endDate = $date . ' 23:59:59';

            $queryBuilder = $entityManager->createQueryBuilder();
            $queryBuilder->select('a')
                         ->from(Article::class, 'a')
                         ->where('a.created_at BETWEEN :start AND :end')
                         ->setParameter('start', $startDate)
                         ->setParameter('end', $endDate);
        
            $arrayArticles = $queryBuilder->getQuery()->getResult();
        }

        $data = [];

        foreach ( $arrayArticles as $oArticle ) {
            $arrArticleData[] = [
                'id'      => $oArticle->getId(),
                'title'   => $oArticle->getTitle(),
                'content' => $oArticle->getContent(),
                'status' => $oArticle->getStatus(),
                'created_at' => $oArticle->getCreatedAt(),
            ];
        }

        $jsonArrData = json_encode($arrArticleData, JSON_UNESCAPED_UNICODE);
        $response = new Response();
        $response->setContent($jsonArrData);
        return $response;
    }

}