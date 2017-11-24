<?php
namespace App\Controller;
use \App\Model\Book;
use \App\Controller\BaseController;

class BooksController extends BaseController
{
    public function index($request, $response, $args)
    {
        $books = Book::all();
        return $this->view->render($response, 'books.twig.html', [
            'books' => $books
        ]);
        //return $books->toJson();
    }

    public function get($request, $response, $args)
    {
        $books = Book::find($args['id']);
        return $books->toJson();
    }

    public function getAll($request, $response, $args)
    {
        $books = Book::all();
        return $books->toJson();
    }

    public function add($request, $response, $args)
    {
        $params = (object) $request->getParams();
        $book = new Book(array(
            'book_name' => $params->book_name,
            'status' => $params->status
        ));
        $logger = $this->logger;
        $logger->info('Book Created!', $book->toArray());
        $book->save();
        echo $book->toJson();
    }

    public function change($request, $response, $args)
    {
        $params = (object) $request->getParams();
        $book = Book::find($args['id']);

        if(isset($params->book_name)) $book->book_name = $params->book_name;
        if(isset($params->status)) $book->status = $params->status;

        $book->save();
        echo $book->toJson();
    }

    public function remove($request, $response, $args)
    {
        $book = Book::find($args['id']);
        if ($book != null){
            $book->delete();
            echo $book->toJson();
        }
    }
}