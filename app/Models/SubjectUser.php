<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectUser extends Model
{
    use HasFactory;
    protected $table = 'subject_users'; // اسم الجدول المرتبط بالنموذج

    protected $fillable = ['mark']; // حقول يمكن تعبئتها

    // إضافة العلاقة بين المستخدمين والمواضيع
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
