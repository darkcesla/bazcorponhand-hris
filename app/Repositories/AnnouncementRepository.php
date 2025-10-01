<?php

namespace App\Repositories;

use App\Models\Announcement;
use Illuminate\Database\Eloquent\Collection;
use Exception;

class AnnouncementRepository
{
    public function getList($params)
    {
        try {
            $query = Announcement::query();
            $query->with(['company:id,site'])
                ->select(
                    'id',
                    'title',
                    'content',
                    'company_id',
                    'created_at'
                )
                ->orderBy('created_at', 'desc');

            if (isset($params['company_id'])) {
                $query->where(function ($q) use ($params) {
                    $q->where('company_id', $params['company_id'])
                        ->orWhereNull('company_id');
                });
            }
            if (isset($params['page']) && isset($params['per_page'])) {
                $data = $query->paginate($params['per_page']);
            } else {
                $data = $query->get();
            }
            if ($data === null) {
                throw new \Exception("Error: Announcement::getList() returned null.");
            }
            return $data;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function show(int $id)
    {
        try {
            $data = Announcement::with('company:id,site')->find($id);
            return $data;
        } catch (Exception $e) {
            report($e);
            return null;
        }
    }

    public function create(array $data)
    {
        try {
            return Announcement::create($data);
        } catch (\TypeError $e) {
            throw new \DomainException('Invalid data type');
        } catch (\UnexpectedValueException $e) {
            throw new \DomainException('Invalid data value');
        } catch (\Exception $e) {
            report($e);
            throw $e;
        }
    }

    public function update(int $id, array $data)
    {
        try {
            $announcement = Announcement::findOrFail($id);
            $announcement->update($data);
            return $announcement;
        } catch (Exception $e) {
            report($e);
            return null;
        }
    }

    public function delete(int $id): bool
    {
        try {
            $announcement = Announcement::findOrFail($id);
            $announcement->delete();
            return true;
        } catch (Exception $e) {
            report($e);
            return false;
        }
    }
}
