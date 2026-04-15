<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class TemplateResource extends JsonResource
{
    private function assetUrl(Request $request, ?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        return rtrim($request->getSchemeAndHttpHost(), '/') . '/storage/' . ltrim($path, '/');
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'type' => $this->type,
            'price' => (int) $this->price,
            'file' => $this->file,
            'file_url' => $this->assetUrl($request, $this->file),
            'preview' => $this->preview,
            'preview_url' => $this->assetUrl($request, $this->preview),
            'preview_video' => $this->preview_video,
            'preview_video_url' => $this->assetUrl($request, $this->preview_video),
            'download_count' => (int) $this->download_count,
            'average_rating' => (float) $this->average_rating,
            'rating_count' => (int) $this->rating_count,
            'creator' => new UserResource($this->whenLoaded('user')),
            'software' => new SoftwareResource($this->whenLoaded('software')),
            'category' => new TemplateCategoryResource($this->whenLoaded('category')),
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
