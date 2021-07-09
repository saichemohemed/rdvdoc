<?php

namespace App\Repository;

use App\Entity\Wilaya;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Wilaya|null find($id, $lockMode = null, $lockVersion = null)
 * @method Wilaya|null findOneBy(array $criteria, array $orderBy = null)
 * @method Wilaya[]    findAll()
 * @method Wilaya[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WilayaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Wilaya::class);
    }

    // /**
    //  * @return Wilaya[] Returns an array of Wilaya objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Wilaya
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */



    public function WilayaList($term)
    {
		
        $qb = $this->createQueryBuilder('w');
        $qb ->select('w.Wilaya , w.Ville')
            ->Where('CONCAT(w.Wilaya, \' \', w.Ville) LIKE :val
                OR  CONCAT(w.Ville, \' \', w.Wilaya) LIKE :val'
                        )
            ->setParameter('val', $term.'%');

        $arrayAss= $qb  ->setMaxResults(7)
                        ->getQuery()
                        ->getArrayResult();
         
        // Transformer le tableau associatif en un tableau standard
        $array = array();
        foreach($arrayAss as $data)
        {
			$str = array();
			$str['value'] = $data['Wilaya'].' '.$data['Ville'];
            array_push($array, $str);


        }
        if(empty($arrayAss)) {
            $str['value'] = "aucun résultat trouvé veuillez vérifier les données Wilaya";
            array_push($array, $str);

        }
    
        return $array;
	}
  


}
