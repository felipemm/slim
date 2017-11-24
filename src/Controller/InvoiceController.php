<?php
namespace App\Controller;
use \App\Model\Invoice;
use \App\Model\Book;
use \App\Model\User;
use \App\Controller\BaseController;
use Slim\Http\UploadedFile;

class InvoiceController extends BaseController
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
    
    
    public function uploadFile($request, $response, $args)  
    {
        $user_id = $request->getAttribute('user_id');
        $user = Book::find($user_id);
        if ($user != null){
            $directory = $this->upload_directory . DIRECTORY_SEPARATOR . $user_id . DIRECTORY_SEPARATOR . "invoices";
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }

            $uploadedFiles = $request->getUploadedFiles();

            // handle single input with multiple file uploads
            foreach ($uploadedFiles['invoice'] as $uploadedFile) {
                if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
                    $filename = $this->moveUploadedFile($directory, $uploadedFile);
                    $response->write('uploaded ' . $filename );
                }
            }        
        }
    }
    
    /**
     * Moves the uploaded file to the upload directory and assigns it a unique name
     * to avoid overwriting an existing uploaded file.
     *
     * @param string $directory directory to which the file is moved
     * @param UploadedFile $uploaded file uploaded file to move
     * @return string filename of moved file
     */
    private function moveUploadedFile($directory, UploadedFile $uploadedFile)
    {
            $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
            $basename = bin2hex(random_bytes(20)); // see http://php.net/manual/en/function.random-bytes.php
            $filename = sprintf('%s.%0.20s', $basename, $extension);

            $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

            return $filename;
    }
}

