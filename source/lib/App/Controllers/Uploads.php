<?php
namespace App\Controllers;

use App\Controller;
use Upload\Exception\UploadException;
use Doctrine\ORM\Tools\Pagination\Paginator;

class Uploads extends Controller
{
    protected function upload($tag = null)
    {
        if ($this->request()->isPost() && isset($_FILES['uploadfile']) && ! empty($_FILES['uploadfile']['name'])) {
            try {
                $this->uploads()->upload('uploadfile', $tag);
            } catch (\Exception $e) {
                if ($e instanceof UploadException) {
                    $this->addError('Файл не прошел валидацию!');
                } else {
                    $this->addError($e->getMessage());
                }
            }
        }
    }

    public function show($tag = null, $page = 1)
    {
        $this->upload($tag);
        $query = $this->uploads()->createQueryBuilder('u')
                                 ->orderBy('u.id', 'DESC');
        if ( ! empty($tag)) {
            $query->andWhere('u.tag = :tag')
                  ->setParameter('tag', $tag);
        }
        $perPage = 10;
        $query = $query->getQuery()
                       ->setFirstResult($perPage * ($page - 1))
                       ->setMaxResults($perPage);;
        $list = new Paginator($query);
        $total = count($list);
        $pages = ceil($total/$perPage);
        $this->render('upload.list.twig', array('list'=>$list,
                                                'page'=>$page,
                                                'pages'=>$pages,
                                                'urlId'=>'uploads-show',
                                                'urlParams'=>array('tag'=>$tag)));
    }
}
