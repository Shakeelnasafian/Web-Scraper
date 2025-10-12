<?php

namespace App\Filament\Resources\Articles\Pages;

use App\Filament\Resources\Articles\ArticleResource;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;
use Filament\Notifications\Notification;

class ViewArticle extends ViewRecord
{
    protected static string $resource = ArticleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            DeleteAction::make()
                ->requiresConfirmation(),
            Action::make('duplicate')
                ->label('Duplicate Article')
                ->icon('heroicon-o-document-duplicate')
                ->requiresConfirmation()
                ->modalHeading('Duplicate Article')
                ->modalDescription('Are you sure you want to duplicate this article?')
                ->action(function () {
                    $originalArticle = $this->record;
                    
                    $duplicatedArticle = $originalArticle->replicate();
                    $duplicatedArticle->title = 'Copy of ' . $originalArticle->title;
                    $duplicatedArticle->slug = 'copy-of-' . $originalArticle->slug;
                    $duplicatedArticle->status = 'draft';
                    $duplicatedArticle->save();
                    
                    Notification::make()
                        ->title('Article duplicated successfully!')
                        ->success()
                        ->send();
                        
                    return redirect()->route('filament.admin.resources.articles.edit', $duplicatedArticle);
                }),
            Action::make('view_live')
                ->label('View Live')
                ->icon('heroicon-o-eye')
                ->url(fn () => url('/articles/' . $this->record->slug))
                ->openUrlInNewTab()
                ->visible(fn () => $this->record->status === 'published'),
        ];
    }

    public function getTitle(): string
    {
        return "Viewing: {$this->record->title}";
    }

    protected function getViewData(): array
    {
        return [
            'relatedByCategory' => $this->getRelatedByCategory(),
            'relatedByAuthor' => $this->getRelatedByAuthor(),
            'relatedBySource' => $this->getRelatedBySource(),
        ];
    }

    protected function getRelatedByCategory()
    {
        return $this->record->category
            ? $this->record->category->articles()
                ->where('id', '!=', $this->record->id)
                ->where('status', 'published')
                ->latest()
                ->limit(5)
                ->get()
            : collect();
    }

    protected function getRelatedByAuthor()
    {
        return $this->record->author
            ? $this->record->author->articles()
                ->where('id', '!=', $this->record->id)
                ->where('status', 'published')
                ->latest()
                ->limit(5)
                ->get()
            : collect();
    }

    protected function getRelatedBySource()
    {
        return $this->record->source
            ? $this->record->source->articles()
                ->where('id', '!=', $this->record->id)
                ->where('status', 'published')
                ->latest()
                ->limit(5)
                ->get()
            : collect();
    }
}
