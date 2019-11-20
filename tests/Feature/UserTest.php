<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Model\User;

class UserTest extends TestCase {

    //use RefreshDatabase; //注意此命令会清空数据库
    private $accessToken;
    private $header;

    protected function setUp(): void {
        parent::setUp();
        // factory(User::class)->make(['user_id'=>2]);
        $this->accessToken = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjNjZTBjNTUxOWI4NGZjYjU2MmI0ZDZhNGIzOTEwMDE1YWRiMDQwYzU0MzIxYjhmYTE3YjliZDc1ZTYwOTU2OTU2YmU5NGMxMzZlYzgwYWY3In0.eyJhdWQiOiIxIiwianRpIjoiM2NlMGM1NTE5Yjg0ZmNiNTYyYjRkNmE0YjM5MTAwMTVhZGIwNDBjNTQzMjFiOGZhMTdiOWJkNzVlNjA5NTY5NTZiZTk0YzEzNmVjODBhZjciLCJpYXQiOjE1NjE2MTI3NDYsIm5iZiI6MTU2MTYxMjc0NiwiZXhwIjoxNTkzMjM1MTQ2LCJzdWIiOiIiLCJzY29wZXMiOltdfQ.rXaFlyxlpYgZ0CBAJfokFr_kl_0L-aC2qJpRSNwODlupBa_-zYiplC37eJKY-1N24GHp8QWjbwz1Qtknq8MYf8xBS8M4OVpUDawKKJkeSfjxnijQB8P4It4D2bCLdEEfzCcR0B-6gtGUJRjxJqk5F6TZUeK2eK2GuM2Td3NjIHYpYDnUIZ0GUILC8sS3fGrbr2cn63aoJ4U7sMmw3ktKwwxOlb95P4fMtShYp5X0kTwc8eUypQYeJlcHGJLB5tjw6ouy8r97_u-t-BFFSx2ey-plHnm4QAInhGzebl2V0BSYz9z0TM3eEkoQC5WskNHRf8evmYqVWIggwfPw5qwzzdjhi9RV4nQMgMEYeEbZJI3sZc5G7qHsvDXHZMT5b2QrllA0mirr95CdAEQr3FDvOFN-Q50ewJv23fuiozQAMATSRqOYzFj3EfEKX1IOUOrz2s-gb6pxwzlzRvrS1EejXkThdJRnq1T_7sNt5d98ToeHxtyRc3DTEbfOHOkSRQqncq9gv0MVfXaAdEWoML3kidT5vPDlzAwKUd2UgR4iRjk6H7cXjipk3wA-J6kUawQGRikjgHxZBzVW8uU-zzTqUc8oRy5-8XnxSvY2crMI1Wcl9E4qb9OofBUectt7sk5B0GnM-jPEuviaZGLpfSddmdKJZSHLCHKfEXvRSAo_u8c";
        $this->header = [
            'Authorization' => "Bearer " . $this->accessToken
        ];
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testIndex() {
        $response = $this->withHeaders($this->header)->json('GET', 'api/users');
        $response
                ->assertStatus(200)
                ->assertJson([
                    'meta' => []
        ]);
        $response->assertStatus(200);
    }

}
