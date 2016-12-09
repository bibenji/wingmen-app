<?php
namespace Library\Models;

use \Library\Entities\Comment;

class CommentsManager_PDO extends CommentsManager
{
	protected function add(Comment $comment)
	{
		$q = $this->dao->prepare('INSERT INTO comments SET com_event = :com_event, com_creator = :com_creator, com_text = :com_text, date = NOW()');
		$q->bindValue(':com_event', $comment->com_event(), \PDO::PARAM_INT);
		$q->bindValue(':com_creator', $comment->com_creator());
		$q->bindValue(':com_text', $comment->com_text());
		$q->execute();
		$comment->setId($this->dao->lastInsertId());
	}
	
	public function getListOf($event)
	{
		if (!ctype_digit($event))
		{
			throw new \InvalidArgumentException('L\'identifiant de l\'event passé doit être un nombre entier valide');
		}
		$q = $this->dao->prepare('
			SELECT c.id id, c.com_event com_event, c.com_creator com_creator_id, m.pseudo com_creator, m.mb_avatar mb_avatar, c.com_text com_text, c.date date
			FROM comments c, membres m
			WHERE m.id = c.com_creator
			AND com_event = :com_event');
		$q->bindValue(':com_event', $event, \PDO::PARAM_INT);
		$q->execute();
		$q->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Comment');
		$comments = $q->fetchAll();
		foreach ($comments as $comment)
		{
			$comment->setDate(new \DateTime($comment->date()));
		}
		return $comments;
	}
	
	protected function modify(Comment $comment)
	{
		$q = $this->dao->prepare('UPDATE comments SET com_creator = :com_creator, com_text = :com_text WHERE id = :id');
		$q->bindValue(':com_creator', $comment->com_creator());
		$q->bindValue(':com_text', $comment->com_text());
		$q->bindValue(':id', $comment->id(), \PDO::PARAM_INT);
		$q->execute();
	}

	public function get($id)
	{
		$q = $this->dao->prepare('SELECT id, com_event, com_creator, com_text FROM comments WHERE id = :id');
		$q->bindValue(':id', (int) $id, \PDO::PARAM_INT);
		$q->execute();
		$q->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Comment');
		return $q->fetch();
	}
	
	public function delete($id)
	{
		$this->dao->exec('DELETE FROM comments WHERE id = '.(int) $id);
	}
	
}