<?php

/**
 * The note controller: Just an example of simple create, read, update and delete (CRUD) actions.
 */
class DatapointController extends Controller
{
    /**
     * Construct this object by extending the basic Controller class
     */
    public function __construct()
    {
        parent::__construct();

        // VERY IMPORTANT: All controllers/areas that should only be usable by logged-in users
        // need this line! Otherwise not-logged in users could do actions. If all of your pages should only
        // be usable by logged-in users: Put this line into libs/Controller->__construct
        //Auth::checkAuthentication();
    }

     /**
     * This method controls what happens when you move to /note/index in your app.
     * Gets all notes (of the user).
     */
    public function index()
    {
        /*$this->View->render('note/index', array(
            'notes' => NoteModel::getAllNotes()
        ));*/
    }

    /**
     * This method controls what happens when you move to /note/delete(/XX) in your app.
     * Deletes a note. In a real application a deletion via GET/URL is not recommended, but for demo purposes it's
     * totally okay.
     * @param int $note_id id of the note
     */
    public function create()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        



        $this->View->render('datapoint/new', array(
            'result' => DatapointModel::createDatapointFromImp($data)
        ));
        //NoteModel::deleteNote($note_id);
        //Redirect::to('note');
    }
    
}
