<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use App;

class ConvertBase extends Command
{

    protected $connection = 'trip';

    protected $take = 200;
    protected $chunk = 50;
    protected $skip = 0;

    protected $copyFiles = false;

    protected $client;

    public function __construct()
    {
        parent::__construct();

        $this->client = new \GuzzleHttp\Client();
        Model::unguard();
    }

    // Nodes

    public function getNode($nid)
    {
        $query = \DB::connection($this->connection)
            ->table('node')
            ->join('node_revisions', 'node_revisions.nid', '=', 'node.nid')
            ->where('node.nid', '=', $nid)
            ->where('node.uid', '>', 0)
            ->where('node.status', '=', 1)
            ->first();

        return $query;
    }

    public function getNodes($type)
    {
        $query = \DB::connection($this->connection)
            ->table('node')
            ->join('node_revisions', 'node_revisions.nid', '=', 'node.nid')
            ->where('node.uid', '>', 0)
            ->where('node.status', '=', 1)
            ->where('node.type', '=', $type)
            ->orderBy('node.last_comment', 'desc')
            ->skip($this->skip)
            ->take($this->take);
        
        return $query;
    }

    public function convertNode($node, $modelname, $type)
    {

        if (!$modelname::find($node->nid)) {
            $model = new $modelname;

            $model->id = $node->nid;
            $model->type = $type;
            $model->user_id = $node->uid;
            $model->title = trim($node->title);
            $model->body = trim($node->body);
            $model->status = 1;
            $model->created_at = \Carbon\Carbon::createFromTimeStamp($node->created);  
            $model->updated_at = \Carbon\Carbon::createFromTimeStamp($node->last_comment); 

            $model->save();
        
            $this->convertUser($node->uid);
            $this->convertComments($node->nid);

            $this->convertFlags($node->nid, $modelname, 'node');

            $this->convertAlias($node->nid, $modelname, 'node');
        
        }

    }


    // Terms

    public function getTerms($vids)
    {
        return \DB::connection($this->connection)
            ->table('term_data')
            ->join('term_hierarchy', 'term_data.tid', '=', 'term_hierarchy.tid')        
            ->whereIn('term_data.vid', (array) $vids);
    }

    public function getTermByName($name)
    {
        return \DB::connection($this->connection)
            ->table('term_data')  
            ->where('name', '=', $name)
            ->first();
    }

    public function createTerm($term, $modelname, $setParent = false)
    {
        if (!$modelname::find($term->tid)) {
            $model = new $modelname;
            $model->id = $term->tid;
            $model->name = $term->name;

            if ($setParent)
            {
                $model->parent_id = $term->parent;
            }
            
            $model->save();
        }
    }

    // Topics

    public $topicMap = [
    
        'Konkurss' => ['delete' => true],
        'Trip.ee tänab' => ['move' => 'Trip.ee tagasiside'], // !
        'Up Traveli reisijutu konkurss' => ['move' => 'Trip.ee tagasiside'],
        'Luksusreis' => ['delete' => true],
        'Paadimatk' => ['move' => 'Matkamine'],
        'Jalgsimatk' => ['move' => 'Matkamine'],
        'Toidu-joogireis' => ['rename' => 'Söök ja jook'],
        'Mägimatk' => ['move' => 'Matkamine'],
        'Sukeldumine' => ['rename' => 'Sukeldumine'],
        'Reisivaluuta' => ['move' => 'Hinnad kohapeal'],
        'Reisikaardid' => ['move' => 'Reisiraamatud'],
        'Reisiveeb' => ['delete' => true],
        'Autahvel' => ['delete' => true],
        'Reisijuhid' => ['rename' => 'Reisijuhid'],
        'Trip.ee tagasiside' => ['rename' => 'Trip.ee'],
        'Reisimeditsiin' => ['rename' => 'Tervis'],
        'Jalgrattamatk' => ['move' => 'Matkamine'],
        'Reisifoto' => ['rename' => 'Fotod'],
        'Lendude soodukad' => ['delete' => true],
        'Kultuurireis' => ['delete' => true],
        'Laevareis' => ['rename' => 'Laevad ja kruiisid'],
        'Hinnad kohapeal' => ['rename' => 'Raha ja hinnad'],
        'Häälega reis' => ['move' => 'Seljakotireis'],
        'Inimesed' => ['rename' => 'Kohalikud inimesed'],
        'Lastega reis' => ['rename' => 'Lastega reisimine'],
        'Seljakotireis' => ['rename' => 'Seljakotireis ja hääletamine'],
        'Reisivarustus' => ['rename' => 'Varustus'],
        'Reisidokumendid' => ['rename' => 'Viisad'],
        'Reisiideed' => ['delete' => true],
        'Reisiöömaja' => ['rename' => 'Majutus ja hotellid'],
        'Reisikiri' => ['delete' => true],
        'Auto-motoreis' => ['rename' => 'Autoreis'],
        'Reisivideo' => ['delete' => true],

        'Lemmikloom reisil' => ['tid' => 5000, 'pattern' => '/(lemmikloom|koer|\skass)/i'],
        'GPS ja kaardid' => ['tid' => 5001, 'pattern' => '/GPS/'],
        'Autorent' => ['tid' => 5002, 'pattern' => '/(autorent|rendia|renti)/i'],
        'Motoreis' => ['tid' => 5003, 'pattern' => '/(mootor|moto)/i'],
        'Turvalisus' => ['tid' => 5004, 'pattern' => '/(turval|varasta)/i']

    ];


    public function processTopic($topic)
    {
        
        if ($rename = array_get($this->topicMap, $topic->name . '.rename')) {
            $topic->name = $rename;
        }

        if (array_get($this->topicMap, $topic->name . '.move') || array_get($this->topicMap, $topic->name . '.delete')) {
            return false;
        }

        return $topic;
    }

    public function getNewTopics()
    {

        $topics = [];

        array_walk($this->topicMap, function($value, $key) use (&$topics) {
            if (array_key_exists('tid', $value)) {   
                
                $topics[$key] = array_merge($value, ['name' => $key]);
            
            }
        
        });

        return $topics;
    }


    // Node terms

    public function getNodeTerms($nid, $vids)
    {
        return \DB::connection($this->connection)
            ->table('term_node')
            ->join('term_data', 'term_node.tid', '=', 'term_data.tid')              
            ->where('term_node.nid', '=', $nid)
            ->whereIn('term_data.vid', (array) $vids)
            ->get();
    }

    public function insertPivot($table, $key1, $value1, $key2, $value2)
    {
        \DB::table($table)->insert(
                array(
                    $key1 => $value1, 
                    $key2 => $value2 
                )
            );
    }

    public function processNodeTopic($topic)
    {
        if ($move = array_get($this->topicMap, $topic->name . '.move')) {
            $new = $this->getTermByName($move);
            return $new;
        }

        if (array_get($this->topicMap, $topic->name . '.delete')) {
            return false;
        }

        return $topic;
    }


    public function convertNodeDestinations($node)
    {
        $terms = $this->getNodeTerms($node->nid, 6); // Sihtkohad

        foreach ($terms as $term) {
            $this->insertPivot('content_destination', 'content_id', $node->nid, 'destination_id', $term->tid);
        }
    }

    public function convertNodeTopics($node)
    {
        
        $terms = $this->getNodeTerms($node->nid, [5, 9]); // Reisistiilid, Rubriigid

        foreach ($terms as $term) {
            if ($processed_term = $this->processNodeTopic($term)) {
                $this->insertPivot('content_topic', 'content_id', $node->nid, 'topic_id', $processed_term->tid);
            }            
        }
 
    }

    public function newNodeTopics($node)
    {
        $topics = $this->getNewTopics();

        foreach ($topics as $topic) {

            if (preg_match($topic['pattern'], $node->title . $node->body)) {
 
                $this->insertPivot('content_topic', 'content_id', $node->nid, 'topic_id', $topic['tid']);
            }

        }
 
    }

    
    public function convertNodeCarriers($node)
    {
        $terms = $this->getNodeTerms($node->nid, 23); // Lennufirmad

        foreach ($terms as $term) {
            $this->insertPivot('content_carrier', 'content_id', $node->nid, 'carrier_id', $term->tid);
        }
    }



    // Comments

    public function getComments($nid)
    {
        return \DB::connection($this->connection)
            ->table('comments')
            ->where('nid', '=', $nid);
    }

    public function convertComments($nid, $status = 0)
    {            
        $comments = $this->getComments($nid)->where('status', '=', $status)->get();

        foreach($comments as $comment) {

            $model = new \App\Comment;

            $model->id = $comment->cid;
            $model->user_id = $comment->uid;
            $model->content_id = $comment->nid;
            $model->body = $comment->comment;
            $model->status = 1 - $comment->status;
            $model->created_at = \Carbon\Carbon::createFromTimeStamp($comment->timestamp);  
            $model->updated_at = \Carbon\Carbon::createFromTimeStamp($comment->timestamp); 

            $model->save();
    
            $this->convertUser($comment->uid);
            
            $this->convertFlags($comment->cid, 'App\Comment', 'comment');
        }
    }

    // Users

    protected $roleMap = [
        'authenticated user' => 'regular',
        'administrator' => 'admin',
        'editor' => 'admin',
        'senior editor' => 'admin',
        'Ärikasutaja' => 'regular',
        'Tavakasutaja' => 'regular',
        'Ärikasutaja 2' => 'regular',
        'superuser' => 'superuser',
        'viktoriin' => 'regular',
    ];

    public function getUser($uid)
    {
        return \DB::connection($this->connection)
            ->table('users')      
            ->join('users_roles', 'users_roles.uid', '=', 'users.uid')
            ->where('users.uid', '=', $uid)
            ->first();
    }

    public function getRole($rid)
    {
        $role = \DB::connection($this->connection)
            ->table('role')      
            ->whereRid($rid)
            ->lists('name')[0];
        
        return $this->roleMap[$role];
    }

    public function createUser($user)
    {
        $model = new \App\User;

        $model->id = $user->uid;
        $model->name = $user->name;
        $model->email = $user->mail;

        $model->password = bcrypt($user->name); // Legacy md5 password: $user->pass

        $model->role = $this->getRole($user->rid);

        $model->created_at = \Carbon\Carbon::createFromTimeStamp($user->created);  
        $model->updated_at = \Carbon\Carbon::createFromTimeStamp($user->access);  
       
        $model->save();

        if ($user->picture) {

            $this->convertLocalImage($user->uid, $user->picture, '\App\User', 'user');
        
        }
    }


    public function convertUser($uid)
    {
        if (!\App\User::find($uid) && $uid > 0) {

            $user = $this->getUser($uid);
            $this->createUser($user);
            
        }
        
    }

    // Fields

    public function convertUrl($id, $url, $modelName)
    {

        $model = $modelName::findOrFail($id);

        $model->url = $url;

        $model->save();
    
    }

    public function convertLocalImage($id, $imagePath, $modelName, $type)
    {

        $model = $modelName::findOrFail($id);

        $model->image = basename($imagePath);

        $model->save();

        $from = 'http://trip.ee/' . $imagePath;
        $to = public_path() . '/images/' . $type . '/' . basename($imagePath);

        if ($this->copyFiles) {

            $this->copyFile($from, $to);
        }
    }

    public function convertRemoteImage($id, $imageUrl, $modelName, $type)
    {

        $ext = pathinfo($imageUrl)['extension'];
        $imageFile = $type . '-' . $id . '.' . $ext;

        $model = $modelName::findOrFail($id);

        $model->image = $imageFile;

        $model->save();

        $from = $imageUrl;
        $to = public_path() . '/images/' . $type . '/' . $imageFile;

        if ($this->copyFiles) {
        
            $this->copyFile($from, $to);
        
        }
    }


    // Flags

    public function getFlags($id, $type)
    {
        return \DB::connection($this->connection)
           ->table('flag_content')
           ->where('content_id', $id)
           ->where('content_type', $type) // node, comment, term
           ->orderBy('timestamp', 'desc')
           ->get();
    }


    public function createFlag($flag, $modelname)
    {
        $model = new \App\Flag;

        $model->user_id = $flag->uid;

        $model->flag_type = $flag->flag_type;

        $model->flaggable_type = $modelname;
        $model->flaggable_id = $flag->content_id;

        $model->created_at = \Carbon\Carbon::createFromTimeStamp($flag->timestamp);  
        $model->updated_at = \Carbon\Carbon::createFromTimeStamp($flag->timestamp);  
       
        $model->save();

    }

    public function convertFlags($id, $modelname, $type)
    {
        $flag_map = array(
            '2' => 'good',
            '3' => 'bad',
            '4' => 'good',
            '5' => 'bad'
         );

        $flags = $this->getFlags($id, $type);
            
        foreach($flags as $flag) {
            $flag->flag_type = $flag_map[$flag->fid];
            $this->createFlag($flag, $modelname);

            $this->convertUser($flag->uid);
        }   
    }


    // Aliases

    public function getAlias($nid)
    {
        return \DB::connection($this->connection)
            ->table('url_alias')
            ->where('src', '=', 'node/' . $nid)
            ->first();
    }

    public function convertAlias($nid)
    {
        if ($alias = $this->getAlias($nid)) {

        \DB::table('content_alias')
            ->insert([
                'content_id' => $nid,
                'alias' => $alias->dst
            ]);
        }
    
    }

    // Utils 
    
    public function copyFile($from, $to)
    {
        $response = $this->client->get($from, [
            'save_to' => $to,
            'exceptions' => false
        ]);
    }

    public function chunkLimit()
    {

        return ($this->take / $this->chunk) - 1;
    }

    public function formatTimestamp($timestamp)
    {

        if (! $timestamp) return null;

        return \Carbon\Carbon::createFromTimeStamp($timestamp)->toDateTimeString();
    }

    public function formatDateTime($datetime)
    {
        if (! $datetime) return null;

        $el = explode('T', $datetime);

        return \Carbon\Carbon::createFromFormat('Y-m-d', $el[0])->startOfDay()->toDateTimeString();
    }

    public function formatFields($node, $fields)
    {
    
        return  join("\n", array_map(function($field) use ($node) {
        
            return '<strong>' . $field . '</strong>: ' . $node->$field;
    
        }, $fields));
    
    }

    public function scrambleString($string)
    {

        $string = strip_tags($string);
        $output = '';
        for ($i = 0; $i < strlen($string) - 1; $i++) {
            $char = mb_substr($string, $i, 1);
            $output .= preg_match("/[A-Ya-y]/", $char) ? chr(ord($char) + 1) : $char;
        }

        return $output;

    }

}
