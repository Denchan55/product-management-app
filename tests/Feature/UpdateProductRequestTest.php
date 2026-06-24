<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Season;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class UpdateProductRequestTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 正常系_画像なしでも更新できる()
    {
        // Arrange
        $season = Season::factory()->create();
        $product = Product::factory()->create();

        $data = [
            'name' => '更新後の商品',
            'price' => 800,
            'season' => [$season->id],
            'description' => '更新後の説明文',
        ];

        // Act
        $response = $this->put(route('products.update', ['id' => $product->id]), $data);

        // Assert
        $response->assertSessionHasNoErrors();
        $response->assertStatus(302);
    }

    /** @test */
    public function 正常系_画像ありでも更新できる()
    {
        // Arrange
        $season = Season::factory()->create();
        $product = Product::factory()->create();

        $data = [
            'name' => 'テスト商品',
            'price' => 500,
            'image' => UploadedFile::fake()->image('test.jpg'),
            'season' => [$season->id],
            'description' => '説明文です。',
        ];

        // Act
        $response = $this->put(route('products.update', ['id' => $product->id]), $data);

        // Assert
        $response->assertSessionHasNoErrors();
        $response->assertStatus(302);
    }

    /** @test */
    public function 異常系_商品名が空ならエラー()
    {
        // Arrange
        $season = Season::factory()->create();
        $product = Product::factory()->create();

        $data = [
            'name' => '',
            'price' => 100,
            'season' => [$season->id],
            'description' => '説明文',
        ];

        // Act
        $response = $this->put(route('products.update', ['id' => $product->id]), $data);

        // Assert
        $response->assertSessionHasErrors([
            'name' => '商品名を入力してください',
        ]);
    }

    /** @test */
    public function 異常系_値段が空ならエラー()
    {
        // Arrange（準備）
        $season = Season::factory()->create();
        $product = Product::factory()->create();

        $data = [
            'name' => 'テスト商品',
            'price' => '',
            'image' => UploadedFile::fake()->image('test.jpg'),
            'season' => [$season->id],
            'description' => '説明文',
        ];

        // Act（実行）
        $response = $this->put(route('products.update', ['id' => $product->id]), $data);

        // Assert（検証）
        $response->assertSessionHasErrors([
            'price' => '値段を入力してください',
        ]);
    }

    /** @test */
    public function 異常系_値段が文字列ならエラー()
    {
        // Arrange（準備）
        $season = Season::factory()->create();
        $product = Product::factory()->create();

        $data = [
            'name' => 'テスト商品',
            'price' => '文字列',
            'image' => UploadedFile::fake()->image('test.jpg'),
            'season' => [$season->id],
            'description' => '説明文',
        ];

        // Act（実行）
        $response = $this->put(route('products.update', ['id' => $product->id]), $data);

        // Assert（検証）
        $response->assertSessionHasErrors([
            'price' => '数値で入力してください',
        ]);
    }

    /** @test */
    public function 異常系_値段が範囲外ならエラー()
    {
        // Arrange（準備）
        $season = Season::factory()->create();
        $product = Product::factory()->create();

        $data = [
            'name' => 'テスト商品',
            'price' => 10001,
            'image' => UploadedFile::fake()->image('test.jpg'),
            'season' => [$season->id],
            'description' => '説明文',
        ];

        // Act（実行）
        $response = $this->put(route('products.update', ['id' => $product->id]), $data);

        // Assert（検証）
        $response->assertSessionHasErrors([
            'price' => '0〜10000円以内で入力してください',
        ]);
    }

    /** @test */
    public function 異常系_画像が_pd_fならエラー()
    {
        // Arrange（準備）
        $season = Season::factory()->create();
        $product = Product::factory()->create();
        $data = [
            'name' => 'テスト商品',
            'price' => 100,
            'image' => UploadedFile::fake()->create('test.pdf', 100),
            'season' => [$season->id],
            'description' => '説明文',
        ];

        // Act（実行）
        $response = $this->put(route('products.update', ['id' => $product->id]), $data);

        // Assert（検証）
        $response->assertSessionHasErrors([
            'image' => '「.png」または「.jpeg」形式でアップロードしてください',
        ]);
    }

    /** @test */
    public function 異常系_季節が空ならエラー()
    {
        // Arrange（準備）
        $season = Season::factory()->create();
        $product = Product::factory()->create();

        $data = [
            'name' => 'テスト商品',
            'price' => 100,
            'image' => UploadedFile::fake()->image('test.jpg'),
            'season' => [],
            'description' => '説明文',
        ];

        // Act（実行）
        $response = $this->put(route('products.update', ['id' => $product->id]), $data);

        // Assert（検証）
        $response->assertSessionHasErrors([
            'season' => '季節を選択してください',
        ]);
    }

    /** @test */
    public function 異常系_商品説明が空ならエラー()
    {
        // Arrange（準備）
        $season = Season::factory()->create();
        $product = Product::factory()->create();

        $data = [
            'name' => 'テスト商品',
            'price' => 100,
            'image' => UploadedFile::fake()->image('test.jpg'),
            'season' => [$season->id],
            'description' => '',
        ];

        // Act（実行）
        $response = $this->put(route('products.update', ['id' => $product->id]), $data);

        // Assert（検証）
        $response->assertSessionHasErrors([
            'description' => '商品説明を入力してください',
        ]);
    }

    /** @test */
    public function 異常系_商品説明が121文字ならエラー()
    {
        // Arrange（準備）
        $season = Season::factory()->create();
        $product = Product::factory()->create();
        $data = [
            'name' => 'テスト商品',
            'price' => 100,
            'image' => UploadedFile::fake()->image('test.jpg'),
            'season' => [$season->id],
            'description' => str_repeat('a', 121),
        ];

        // Act（実行）
        $response = $this->put(route('products.update', ['id' => $product->id]), $data);

        // Assert（検証）
        $response->assertSessionHasErrors([
            'description' => '120文字以内で入力してください',
        ]);
    }
}
