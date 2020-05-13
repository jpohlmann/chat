<?php
/**
 * Message model
 *
 * Model for interacting with messages in the system
 *
 * @author Justin Pohlmann
 */
namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Carbon\Carbon;

class Message extends Model {

    /**
     * Connected table
     *
     * @var string
     */
    protected $table = 'messages';

    /**
     * Editable fields
     *
     * @var array
     */
    protected $fillable = [
        'message',
        'sender_id',
        'recipient_id'
    ];

    /**
     * Sender of the message
     *
     * @return HasOne
     */
    public function sender() : HasOne
    {
        return $this->hasOne('App\Http\Models\User', 'sender_id', 'id');
    }

    /**
     * Recipient of the message
     *
     * @return HasOne
     */
    public function recipient()
    {
        return $this->hasOne('App\Http\Models\User', 'recipient_id', 'id');
    }

    /**
     * Filter on parameters
     *
     * @param array $values
     */
    public function filter(array $values) {

        $message = $this->newQuery();
        if (isset($values['recipient_id'])) {
            $message->where('recipient_id', $values['recipient_id']);
        }
        if (isset($values['sender_id'])) {
            $message->where('sender_id', $values['sender_id']);
        }
        if (isset($values['limit'])) {
            $message->simplePaginate($values['limit']);
        } else {
            $message->where('created_at', '>', Carbon::now()->subDays(30));
        }
        $message->orderBy('created_at', 'desc');
        return $message->get();
    }
}