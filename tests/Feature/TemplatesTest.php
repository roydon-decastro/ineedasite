<?php

namespace Tests\Feature;

use App\Template;
use Carbon\Carbon;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class TemplatesTest extends TestCase
{

    protected $user;

    protected function setUp(): void
    {
        // this will run before any test run
        parent::setUp();
        $this->user = factory(User::class)->create();
    }


    /** @test */
    public function unauthenticated_user_should_be_redirected_to_login() {

        // try to post to database new template from data
        // $response = $this->post('/api/templates/', $this->data());
        // overwrite api_token to blank
        $response = $this->post( '/api/templates', array_merge( $this->data(), ['api_token' => '']));


        // check if they are redirected to login page
        $response->assertRedirect('/login');

        // check if no record has been added, we expect 0
        $this->assertCount(0, Template::all());
    }


    /** @test */
    public function a_list_of_templates_can_be_fetched_for_the_authenticated_user() {

        $this->withoutExceptionHandling();

        // create 2 users using factory
        $user = factory(User::class)->create();
        $anotherUser = factory(User::class)->create();

        // create 2 templates connecting them to the users above using userid
        $template = factory(Template::class)->create(['user_id' => $user->id]);
        $anotherTemplate = factory(Template::class)->create(['user_id' => $anotherUser->id]);

        $response = $this->get('/api/templates?api_token=' . $user->api_token);

        $response->assertJsonCount(1);
        //check if we're getting the proper id of template for user
        // OLD
        // $response->assertJson([['id'=> $template->id]]);
        // NEW
        $response->assertJson([
            "data" => [
                [
                "data" => [
                    'template_id' => $template->id
                    ]
                ]
            ]
        ]);
    }


    public function a_template_can_be_added() {
            
        $this->withoutExceptionHandling();
	
        $this->post( '/api/templates', $this->data());        
        $template = Template::first();
	
        // $this->assertCount( 1, Template::all());
        $this->assertEquals('Test Name1', $template->name);
        $this->assertEquals('cool1', $template->description);
        $this->assertEquals('image1.jpg', $template->photo);
        $this->assertEquals('06/05/2003', $template->livedate);
    }

   /** @test */
   public function an_authenticated_user_can_add_a_template() {

        // $this->withoutExceptionHandling();
        //use faker to create a new user
        // $user = factory(User::class)->create();

        // dd($user->api_token);
        // OLD
        // $this->post( '/api/templates', array_merge( $this->data(), ['api_token' => $user->api_token]));
        // OLD-2
        //$this->post( '/api/templates', $this->data());
        // NEW
        $response = $this->post( '/api/templates', $this->data());
        $template = Template::first();

        // $this->assertCount( 1, $template);
        $this->assertEquals('Test Name1', $template->name);
        $this->assertEquals('cool1', $template->description);
        $this->assertEquals('06/05/2003', $template->livedate->format('m/d/Y'));
        $this->assertEquals('image1.jpg', $template->photo);
        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJson([
            'data' => [
                'template_id' => $template->id,
            ],
            'links' => [
                'self' => url('/templates/' . $template->id),
            ]
        ]);

    }   

    /** @test */
    public function fields_are_required() {
        collect(['name', 'description', 'photo', 'livedate'])
        ->each(function ($field){
            $response = $this->post( '/api/templates', array_merge($this->data(), [$field => '']));

            $response->assertSessionHasErrors($field);
            $this->assertCount(0, Template::all());

        });
    }

    /** @test */
    public function livedates_are_properly_stored()
    {
        $response = $this->post( '/api/templates', array_merge($this->data(), ['livedate' => 'June 05, 2003']));

        $this->assertCount(1, Template::all());
        $this->assertInstanceOf(Carbon::class, Template::first()->livedate);
        $this->assertEquals('06-05-2003',  Template::first()->livedate->format('m-d-Y'));
    }

    /** @test */
    public function a_template_can_be_retrieved()
    {
        //create template on database, pass user_id to factory
        $template = factory(Template::class)->create(['user_id' => $this->user->id]); 

        //attempt to fetch record on db
        $response = $this->get('/api/templates/' . $template->id . '?api_token=' . $this->user->api_token);

        //check if we have data on the response
        $response->assertJson([
            'data' => [
            'template_id' => $template->id,
            'name' => $template->name,
            'description' => $template->description,
            'photo' => $template->photo,
            'livedate' => $template->livedate->format('m/d/Y'),
            'last_updated' => $template->updated_at->diffForHumans(),
            ]
        ]);
    }

    /** @test */
    public function only_the_users_templates_can_be_retrieved()
    {
        // create a template using id from the user created above in the setup method
        $template = factory(Template::class)->create(['user_id' => $this->user->id]);
        // create a new user
        $anotherUser = factory(User::class)->create();
        // get the newly created template using the id of the anotherUser, which should not be allowed
        $response = $this->get('/api/templates/' . $template->id . '?api_token=' . $anotherUser->api_token);
        // check if we allowed or not the assertion above
        $response->assertStatus(403);
    }


    /** @test */
    public function a_template_can_be_patched()
    {
        $this->withoutExceptionHandling();
        // create a new random template via factory
        // OLD
        // $template = factory(Template::class)->create();
        // NEW
        $template = factory(Template::class)->create(['user_id' => $this->user->id]);

        // modify/update new random template via factory to data sample below
        $response = $this->patch('/api/templates/' . $template->id, $this->data());

        // get fresh copy of the template after patch
        $template = $template->fresh();

        // test the patched record 
        $this->assertEquals('Test Name1', $template->name);
        $this->assertEquals('cool1', $template->description);
        $this->assertEquals('06/05/2003', $template->livedate->format('m/d/Y'));
        $this->assertEquals('image1.jpg', $template->photo);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            'data' => [
                'template_id' => $template->id,
            ],
            'links' => [
                'self' => $template->path(),
            ]
        ]);
    }    

    
    /** @test */
    public function only_the_owner_of_the_template_can_patch_the_template(){

        // create a new random template via factory
        $template = factory(Template::class)->create();

        //create a new user
        $anotherUser = factory(User::class)->create();

        // submit a patch request, but use anotherUser api_token
        $response = $this->patch('/api/templates/' . $template->id, 
            array_merge($this->data(), ['api_token' => $anotherUser->api_token]));
        // since we are using anotherUser->api_token, this should give a status of 403, let's check
        $response->assertStatus(403);

    }

    /** @test */
    public function a_template_can_be_deleted()
    {
        // create a new random template via factory
        $template = factory(Template::class)->create(['user_id' => $this->user->id]);

        // delete new random template 
        $response = $this->delete('/api/templates/' . $template->id, ['api_token' => $this->user->api_token]);

        // check if record was indeed deleted, expected count of 0
        $this->assertCount(0, Template::all());
        $response->assertStatus(Response::HTTP_NO_CONTENT);

    }


    /** @test */
    public function only_the_owner_of_the_template_can_delete_the_template(){

    
        // create a new random template via factory
        $template = factory(Template::class)->create();

        //create a new user
        $anotherUser = factory(User::class)->create();
        
        // delete new random template 
        $response = $this->delete('/api/templates/' . $template->id, ['api_token' => $this->user->api_token]);

        // check if record was indeed deleted, expected count of 0
        $response->assertStatus(403);
    }

    private function data() {
        return [
            'name' => 'Test Name1',
            'description' => 'cool1',
            'photo' => 'image1.jpg',
            'livedate' => '06/05/2003',
            'api_token' => $this->user->api_token,
        ];
    }

}
