<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function generateToken(string $userAgent): string
    {
        $name = $this->email . '-' . $userAgent;
        return $this->createToken($name)->plainTextToken;
    }

    public function deleteCurrentToken(): void
    {
        /** @var \Laravel\Sanctum\PersonalAccessToken $currentAccessToken */
        $currentAccessToken = $this->currentAccessToken();
        $currentAccessToken->delete();
    }

    public function deleteAllTokens(): void
    {
        $this->tokens()->delete();
    }

    /**
     * The preferred sources to the user.
     */
    public function sources(): BelongsToMany
    {
        return $this->belongsToMany(Source::class, 'source_user', 'source_id', 'user_id');
    }

    /**
     * The preferred categories to the user.
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_user', 'category_id', 'user_id');
    }

    /**
     * The preferred authors to the user.
     */
    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class, 'author_user', 'author_id', 'user_id');
    }
}
