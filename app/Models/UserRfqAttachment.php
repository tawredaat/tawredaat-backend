<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRfqAttachment extends Model
{
    // Explicitly define the table name
    protected $table = 'rfq_attachments';

    // Allow mass assignment on the 'rfq_id' and other relevant columns
    protected $fillable = ['rfq_id', 'attachment']; // Add other columns as needed

    public function rfq()
    {
        return $this->belongsTo(UserRfq::class);
    }
}

