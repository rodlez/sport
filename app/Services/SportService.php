<?php

namespace App\Services;

// Models
use App\Models\Sport\Sport;
use App\Models\Sport\SportCategory;
use App\Models\Sport\SportFile;
use App\Models\Sport\SportTag;
use App\Models\Workout\Workout;
// Files
use Illuminate\Support\Facades\Storage;

// Collection
use Illuminate\Database\Eloquent\Collection;

class SportService
{
    /**
     * Inset new Sport and insert the tags in the pivot table sports_tag and if any, the workouts in the pivot table sports_workouts
     */
    public function insertSport(array $data): Sport
    {
        // If category_id is NOT 12 (Workout), selectedWorkouts must be empty
        if ($data['category_id'] != 12) {
            $data['selectedWorkouts'] = [];
        }

        $sport = Sport::create($data);
        $sport->tags()->sync($data['selectedTags']);
        $sport->workouts()->sync($data['selectedWorkouts']);

        return $sport;
    }

    /**
     * Inset new Sport and update the tags in the pivot table sports_tag and if any, the workouts in the pivot table sports_workouts
     */
    public function updateSport(Sport $sport,array $data): Sport
    {
        // If category_id is NOT 12 (Workout), selectedWorkouts must be empty
        if ($data['category_id'] != 12) {
            $data['selectedWorkouts'] = [];
        }       
       
        $sport->update($data);
        $sport->tags()->sync($data['selectedTags']);
        $sport->workouts()->sync($data['selectedWorkouts']);

        return $sport;
    }

    /**
     *  Get all the categories orderby asc
     */
    public function getCategories(): Collection
    {
        return SportCategory::orderBy('name')->get();
    }

    /**
     *  Get all the tags orderby asc
     */
    public function getTags(): Collection
    {
        return SportTag::orderBy('name')->get();
    }

    /**
     *  Get the tags Ids associated to this Sport entry
     */
    public function getSportEntryTags(Sport $sport): array
    {
        $tags = [];
        foreach ($sport->tags as $tag) {
            $tags[] = $tag->pivot->sport_tag_id;
        }

        return $tags;
    }

    /**
     *  Get the workouts Ids associated to this Sport entry
     */
    public function getSportEntryWorkouts(Sport $sport): array
    {
        $tags = [];
        foreach ($sport->workouts as $workout) {
            $tags[] = $workout->pivot->workout_id;
        }

        return $tags;
    }

    /**
     *  Get all the workouts orderby asc
     */
    public function getWorkouts(): Collection
    {
        return Workout::orderBy('title')->get();
    }

    /**
     * Get the tag names given an array with the tag ids
     */

    public function getTagNames(array $tags): array
    {
        $tagsNames = [];
        foreach ($tags as $key => $value) {
            $tagInfo = SportTag::find($value);
            $tagsNames[] = $tagInfo->name;
        }
        return $tagsNames;
    }

    /**
     *  Get tags for this entry
     * 
     * @param Sport $entry
     * @param string $separator Value to separate between tags (- / *) 
     */
    public function displaySportEntryRelatedTags(Sport $entry, string $separator): array
    {
        $tags = $entry->tags;
        $count = 0;
        $result = [];

        foreach ($tags as $tag) {
            $count++;
            if ($count == count($tags))
                $result[] = $tag->name;

            else {
                $result[] = $tag->name . ' ' . $separator . ' ';
            }
        }

        return $result;
    }

    /**
     * Upload a file and return an array with the info to make the insertion in the DB table 
     */

     public function uploadFile(mixed $request, Sport $sport, string $disk, string $storagePath): array
     {  
       
        // Info to store in the DB
         $original_filename = $request->getClientOriginalName();
         $media_type = $request->getMimeType();
         $size = $request->getSize();                 
         // Storage in filesystem file config, specify the storagePath
         $path = Storage::disk($disk)->putFile($storagePath, $request);
         $storage_filename = basename($path);
 
         return [
             'sport_id' => $sport->id,
             'original_filename' => $original_filename,
             'storage_filename' => $storage_filename,
             'path' => $path,
             'media_type' => $media_type,
             'size' => $size,
         ];
     }

      /**
     * Download a file, disposition inline(browser) or attachment(download)
     */

    public function downloadFile(SportFile $file, string $disposition)
    {
        // No need to specify the disposition to download the file.

        $dispositionHeader = [
            'Content-Disposition' => $disposition,
        ];

        if (Storage::disk('public')->exists($file->path)) {
            //return Storage::disk('public')->download($file->path, $file->original_filename, $dispositionHeader);
            return Storage::disk('public')->download($file->path, $file->original_filename);
        } else {
            return back()->with('message', 'Error: File ' . $file->original_filename . ' can not be downloaded.');
        }
    }

    /**
     * Inset new Note and insert the tags in the intermediate table note_tag
     */
    public function deleteFiles(Collection $files)
    {
        foreach ($files as $file) {
            $this->deleteOneFile($file);
        }
    }

    /**
     * Inset new Note and insert the tags in the intermediate table note_tag
     */
    public function deleteOneFile(SportFile $file)
    {
        if (Storage::disk('public')->exists($file->path)) {
            /*  echo $file->path;
             dd('borradito'); */
            Storage::disk('public')->delete($file->path);
            $file->delete();
        }
    }
}
