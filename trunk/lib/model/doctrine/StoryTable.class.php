<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class StoryTable extends Doctrine_Table
{
  const SORT_BY_RATING = 'r.average_vote DESC';
  const SORT_BY_TITLE  = 's.title ASC';


  static public function retrieveForSelect($q, $limit) 
  {
    $query = Doctrine::getTable('Story')->createQuery('s')
              ->where('s.title like ?', "%$q%")
              ->orderBy('s.title asc')
              ->limit(25);
    
    $stories = array();
    foreach( $query->fetchArray() as $story)
    {
      $stories[ $story['id'] ] = $story['title'];
    }
    return $stories;
  }


  static public function retrieveAdminList(Doctrine_Query $q)
  {
    return $q->addFrom('r.StoryType st, r.Creator sf')->addSelect('r.*, st.*, sf.*');
  }



  public function retrieveCached($id, $hydrate = null) 
  {
    
    return Doctrine_Query::create()
            ->select('s.*, r.*')
            ->from('Story s, s.Rating r')
            ->where(is_numeric($id) ? 's.id = ?' : 's.slug = ?')
            ->fetchOne($id, $hydrate);
  }


  public function retrieveByEntity($entity, $limit = false, $sort_order = self::SORT_BY_TITLE)
  {
    return Doctrine_Query::create()
            ->select('s.*, r.*')
            ->from('Story s, s.Rating r, s.Facts f')
            ->where('f.entity_id = ?', $entity)
            ->orWhere('f.related_entity_id = ?', $entity)
            ->orderBy($sort_order)
            ->limit($limit)
            ->execute();
  }

}