<?php

namespace App\Repository;

use App\Entity\Doctor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Doctor|null find($id, $lockMode = null, $lockVersion = null)
 * @method Doctor|null findOneBy(array $criteria, array $orderBy = null)
 * @method Doctor[]    findAll()
 * @method Doctor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DoctorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Doctor::class);
    }


    
    // /**
    //  * @return Doctor[] Returns an array of Doctor objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */  
     /**
    * @return Doctor[] 
    * @return Query
    */
    
    public function findBysearche($willaya ,$doc):array
    {
        $req = $this->createQueryBuilder('d')
                    ->andWhere('d.enabled = 1');

        if($willaya != null){
            $req
            ->leftJoin('App:HospitalCenter', 'U', 'WITH', 'U.doctor = d.id')
            -> andWhere('CONCAT(U.wilaya, \' \', U.town) LIKE :val1
                    OR  CONCAT(U.town, \' \', U.wilaya) LIKE :val1
                    OR d.company LIKE :val1
                    OR U.wilaya LIKE :val1 
                    OR U.town LIKE :val1 
                    OR U.address LIKE :val1'
                             )
				->setParameter('val1', '%'.$willaya.'%');
		}
		
		if($doc != null){
            
            $req
            ->leftJoin('App:HospitalCenter', 'h', 'WITH', 'h.doctor = d.id')
            ->leftJoin('d.specialisation','s')
            ->andwhere('CONCAT(d.lastName, \' \', d.firstName) LIKE :val2 
                    OR CONCAT(d.firstName, \' \', d.lastName) LIKE :val2  
                    OR s.name LIKE :val2 
                    OR h.name LIKE :val2  
                    OR h.type LIKE :val2')
            ->setParameter('val2', '%'.$doc.'%')
            ;
		}
		return $req
            ->getQuery()
            ->getResult()
        ;
    }
    
    
		public function doctorList($term)
    {
		
        $qb = $this->createQueryBuilder('c');
		$qb->leftJoin('App:HospitalCenter', 'h', 'WITH', 'h.doctor = c.id')
            ->leftJoin('c.specialisation','s');
        $qb ->select('c.id,c.lastName,c.firstName,s.name,h.name as company,c.imageName')
			->where('CONCAT(c.lastName, \' \', c.firstName) LIKE :term OR CONCAT(c.firstName, \' \', c.lastName) LIKE :term  
				OR s.name LIKE :term OR h.name LIKE :term  OR h.type LIKE :term')
			->andWhere('c.enabled = 1')
            ->setParameter('term', $term.'%')
		    ->orderBy('c.lastName,c.firstName', 'ASC');
         
        $arrayAss= $qb->getQuery()
                   ->getArrayResult();
         
        // Transformer le tableau associatif en un tableau standard
        $array = array();
        foreach($arrayAss as $data)
        {
			$str = array();
			$str['value'] = $data['lastName'].' '.$data['firstName'];
			$str['c'] = $data['imageName']; 
			$str['desc'] = $data['name'].' '.$data['company'].' ';
            array_push($array, $str);


        }
        if(empty($arrayAss)) {
            $str['value'] = "aucun résultat trouvé veuillez vérifier les données";
            $str['desc'] = " ";
            $str['c'] = ' '; 
            array_push($array, $str);

        }
    
        return $array;
	}
 
}
