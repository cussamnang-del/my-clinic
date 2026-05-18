<?php

namespace App\Services;

use App\Http\Controllers\Admin\DocumentController;
use App\Models\Document;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Holds the business rules for the {@see Document} aggregate.
 *
 * Phase 4 introduces this service as a behaviour-preserving extraction
 * of the relevant slices of {@see DocumentController}.
 * Controllers now delegate persistence to this service, leaving them
 * responsible only for HTTP concerns (request parsing, auth gates,
 * response shape). Future controllers in the new ISO modules (Phase 3)
 * can call this service directly without going through legacy code.
 */
class DocumentService
{
    /**
     * Create or update a Document. The semantics intentionally match
     * the legacy controller — visit_date is stored as a datetime, status
     * is a boolean stored as 0/1, and the authenticated user owns the
     * row.
     *
     * @param  array{customer_id:int,visit_date:string,status:bool,id?:int|null}  $attributes
     */
    public function createOrUpdate(array $attributes): Document
    {
        return DB::transaction(function () use ($attributes) {
            return Document::updateOrCreate(
                ['id' => $attributes['id'] ?? null],
                [
                    'customer_id' => $attributes['customer_id'],
                    'user_id' => Auth::id(),
                    'visit_date' => Carbon::parse($attributes['visit_date'])->toDateTimeString(),
                    'status' => (bool) ($attributes['status'] ?? false),
                ],
            );
        });
    }

    /**
     * Toggle the `status` flag on a document. Returns true when the row
     * was found and updated, false otherwise.
     */
    public function changeStatus(int $documentId, bool $status): bool
    {
        $document = Document::find($documentId);
        if ($document === null) {
            return false;
        }

        $document->status = $status;

        return $document->save();
    }

    /**
     * Soft-delete a document. We intentionally never hard-delete patient
     * records — ISO 15189:2022 §7.5 and our own audit policy require
     * recoverability and a complete history.
     */
    public function delete(Document $document): bool
    {
        return (bool) $document->delete();
    }
}
