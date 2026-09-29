<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * テスト1: ユーザー作成テスト（正常系）
     */
    public function test_user_can_be_created(): void
    {
        // User::factory()->create() でユーザーを作成
        $user = User::factory()->create([
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
        ]);

        // assertDatabaseHas() でデータベースにユーザーが保存されていることを確認
        $this->assertDatabaseHas('users', [
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
        ]);
    }

    /**
     * テスト2: メールアドレス重複テスト（異常系）
     */
    public function test_email_must_be_unique(): void
    {
        // 1人目のユーザーを作成
        User::factory()->create([
            'email' => 'duplicate@example.com',
        ]);

        // expectException() で QueryException が発生することを確認
        $this->expectException(QueryException::class);

        // 同じメールアドレスで2人目のユーザーを作成しようとする
        User::factory()->create([
            'email' => 'duplicate@example.com',
        ]);
    }
}