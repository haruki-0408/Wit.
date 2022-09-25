<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Http\Controllers\TagController;
use App\Models\Tag;
use App\Models\User;

use Tests\TestCase;

class TagTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    use RefreshDatabase;

    protected $user;

    public function setUp(): void
    {
        parent::setUp();
        //ユーザはメソッド毎に変わるが毎回名前だけ同じAuth,Otherというようになるので注意　$this->user->idはアクション毎に異なる
        $this->user = User::factory()->create([
            'name' => 'Auth',
        ]);
    }

    public function test_store_tag()
    {
        //新しくタグを登録する時 前後の空白が適切に取り除かれているかも確認
        //適当な文字列
        $match = '   wit.   ';

        //テーブルに存在しないことを確認
        $this->assertDatabaseMissing('tags', [
            'name' => $match
        ]);

        $tag_controller = new TagController;
        $tag_controller->storeTag($match);

        //空白ありの方は登録されていない
        $this->assertDatabaseMissing('tags', [
            'name' => '   wit.   ',
        ]);
        //テーブルに追加されていることを確認
        $this->assertDatabaseHas('tags', [
            'name' => 'wit.',
            'number' => 1,
        ]);

        //すでにあるタグを追加する時 numberが+1されているか確認する
        $tag_controller->storeTag($match);
        $this->assertDatabaseHas('tags', [
            'name' => 'wit.',
            'number' => 2,
        ]);
    }

    public function test_get_trend()
    {
        $this->actingAs($this->user); //ユーザをログイン状態へ
        //新しくタグを20件登録
        $tags = Tag::factory()->count(20)->create();
        $response = $this->get('/getTrendTags');
        //15件しか返っていないことを確認する
        $response->assertJsonCount(15);

        //タグナンバーが降順になるように並んでいるか確認
        for($tag_number=0;$tag_number<14;$tag_number++){
            $this->assertTrue($response[$tag_number]['number'] >= $response[$tag_number + 1]['number']);
        }
    }
}
