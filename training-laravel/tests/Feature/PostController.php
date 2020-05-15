<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;


class PostController extends TestCase
{

    use DatabaseTransactions;

    public function setUp(): void
    {
        parent::setUp();
    }

    const USER_ID = 7;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_記事が正常に追加されてるか()
    {
        $response = $this->post('/api/post/add', [
            'user_id' => self::USER_ID,
            'title' => 'rggsg',
            'body' => 'fsddfds',
        ]);

        $response->assertStatus(201);
    }

    public function test_記事投稿のバリデーションが正常にされているか()
    {
        $response = $this->post('/api/post/add', [
            'user_id' => self::USER_ID,
            'title' => '',
            'body' => '',
        ]);

        $response->assertStatus(422);
        $expected = [
            'errors' => [
                'title' => [
                    'タイトル を入力してください',
                ],
                'body' => [
                    '本文 を入力してください',
                ],
            ],
            'message' => 'Failed validation',
        ];

        $response->assertExactJson($expected);
    }

    public function test_記事一覧(){
        $response = $this->get('/api/');
        $response->assertStatus(200);
    }

}
