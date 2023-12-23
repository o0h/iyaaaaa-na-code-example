<?php

declare(strict_types=1);

namespace O0h\IyaaaaaNaCodeExample\Controller;

use O0h\IyaaaaaNaCodeExample\Model\User;
use O0h\IyaaaaaNaCodeExample\Model\UserVote;
use O0h\IyaaaaaNaCodeExample\View\Model\RankedHotsnack;

class UserController extends Controller
{
    public function myRanking(): void
    {
        $userId = $_SESSION['user_id'] ?? false;
        if (!$userId) {
            header('Location: /', true, 302);

            exit;
        }

        $userVote = new UserVote();
        $myRanking = $userVote->getUserHotsnack($userId);
        $user = new User();
        $me = $user->get($userId);
        $this->set([
            'me' => $me->fetch(\PDO::FETCH_ASSOC),
            'ranking' => $myRanking->fetchAll(\PDO::FETCH_CLASS, RankedHotsnack::class),
        ]);
        $this->render('user/my_ranking.php');
    }
}
