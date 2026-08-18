<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property int $knowledge_base_id
 * @property string $content
 * @property \Pgvector\Laravel\Vector $embedding
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\KnowledgeBase $knowledgeBase
 * @method static \Database\Factories\DocumentChunkFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DocumentChunk nearestNeighbors(string $column, ?mixed $value, \Pgvector\Laravel\Distance $distance)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DocumentChunk newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DocumentChunk newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DocumentChunk query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DocumentChunk whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DocumentChunk whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DocumentChunk whereEmbedding($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DocumentChunk whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DocumentChunk whereKnowledgeBaseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DocumentChunk whereUpdatedAt($value)
 */
	class DocumentChunk extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $title
 * @property string $original_filename
 * @property string $file_path
 * @property \App\Enums\KnowledgeBaseStatus $status
 * @property string|null $error_message
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DocumentChunk> $chunks
 * @property-read int|null $chunks_count
 * @method static \Database\Factories\KnowledgeBaseFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KnowledgeBase newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KnowledgeBase newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KnowledgeBase query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KnowledgeBase whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KnowledgeBase whereErrorMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KnowledgeBase whereFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KnowledgeBase whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KnowledgeBase whereOriginalFilename($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KnowledgeBase whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KnowledgeBase whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KnowledgeBase whereUpdatedAt($value)
 */
	class KnowledgeBase extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

