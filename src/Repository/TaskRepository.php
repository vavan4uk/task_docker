<?php



namespace App\Repository;

use App\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


class TaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }
    public function findResAll($user, $params = array())
    {
        
        
        $query = $this->createQueryBuilder('t')
                ->addSelect('t.id as tid')
                ->addSelect('t.title as ttitle')
                ->addSelect('t.comment as tcomment')
                ->addSelect('t.dateAt as tdateAt')
                ->addSelect('t.timespent as ttimespent')
                //->setParameter('user', $user )
                ;
                
        $query->where('t.user = :tuser')
                ->setParameter('tuser', $user );        
                
        if( !empty($params['start_date']) )
            $query->andWhere('t.dateAt >= :tstartdateAt')
                ->setParameter('tstartdateAt', $params['start_date'] );

        if( !empty($params['end_date']) )
            $query->andWhere('t.dateAt <= :tenddateAt')
                ->setParameter('tenddateAt', $params['end_date'] );
        
        $query->orderBy('t.id', 'DESC')
        ->getQuery();
        
        return $query;
    }
}
