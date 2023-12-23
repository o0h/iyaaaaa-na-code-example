<?php

declare(strict_types=1);

namespace O0h\IyaaaaaNaCodeExample\Model;

final class UserVote extends DB
{
    public function getUserHotsnack($userId)
    {
        $select = $this->newSelect();
        $select->cols([
            'hotsnack.name ' => 'name',
            'hotsnack.description' =>  'description',
            'COUNT(vote.hotsnack_id)' => 'voted_count',
        ])
            ->from('hotsnack')
            ->join('INNER', 'vote', 'vote.hotsnack_id = hotsnack.id')
            ->where('vote.user_id = :user_id')
            ->groupBy(['vote.hotsnack_id'])
            ->orderBy(['COUNT(vote.hotsnack_id) DESC'])
        ;

        return $this->execute($select, ['user_id' => $userId]);
    }
}
