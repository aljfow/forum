<?php

namespace Tests\Feature;

use Illuminate\Notifications\DatabaseNotification;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NotificationsTest extends TestCase
{

    protected function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->signedIn();
    }

    /**
     * @test
     */
    public function a_notification_is_prepared_when_a_subscribed_thread_receives_a_new_reply_ath_is_not_by_current_user()
    {
        $thread = create('App\Thread')->subscribe();

        $this->assertCount(0, auth()->user()->notifications);

        $thread->addReply([
            'user_id' => auth()->id(),
            'body' => 'some reply here'
        ]);

        $this->assertCount(0, auth()->user()->fresh()->notifications);

        $thread->addReply([
            'user_id' => create('App\User')->id,
            'body' => 'some reply here'
        ]);

        $this->assertCount(1, auth()->user()->fresh()->notifications);
    }

    /**
     * @test
     */
    public function a_user_can_fetch_their_unread_notification()
    {
        create(DatabaseNotification::class);

        $this->assertCount(
            1,
            $this->get("/profiles/" . auth()->user()->name . "/notifications")->json()
        );
    }

    /**
     * @test
     */
    public function a_user_can_mark_a_notification_as_read()
    {
        create(DatabaseNotification::class);

        $this->assertCount(1, auth()->user()->unreadNotifications);

        $notificationId = auth()->user()->unreadNotifications->first()->id;

        $this->delete("/profiles/" . auth()->user()->name . "/notifications/{$notificationId}");

        $this->assertCount(0, auth()->user()->fresh()->unreadNotifications);
    }
}
