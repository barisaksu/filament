<?php

namespace Filament\Pages\Actions;

use Filament\Pages\Contracts\HasRecord;
use Filament\Pages\Page;
use Filament\Support\Actions\Concerns\CanDeleteRecords;
use Illuminate\Database\Eloquent\Model;

class DeleteAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('filament-support::actions/delete.single.label'));

        $this->modalHeading(fn (DeleteAction $action): string => __('filament-support::actions/delete.single.modal.heading', ['label' => $action->getRecordTitle()]));

        $this->modalButton(__('filament-support::actions/delete.single.modal.buttons.delete.label'));

        $this->successNotificationMessage(__('filament-support::actions/delete.single.messages.deleted'));

        $this->action('delete');

        $this->color('danger');

        $this->requiresConfirmation();

        $this->keyBindings(['mod+d']);

        $this->hidden(static function (Model $record): bool {
            if (! method_exists($record, 'trashed')) {
                return false;
            }

            return $record->trashed();
        });

        $this->action(static function (DeleteAction $action, Model $record): void {
            $record->delete();

            $action->success();
        });
    }
}
