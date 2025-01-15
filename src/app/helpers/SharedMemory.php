<?php
/**
 * @ Author: David Lhoumaud
 * @ Create Time: 2024-11-19 15:22:24
 * @ Modified by: David Lhoumaud
 * @ Modified time: 2024-11-19 15:23:06
 * @ Description: classe pour la gestion de la mémoire partagée
 */


namespace App\Helpers;


class SharedMemory
{
    public $shmop;
    public $id;
    public $mode;
    public $byte;
    private $semaphore;

    public function __construct()
    {
        $this->id = ftok(__FILE__, 't');
        $this->mode = 0644;
        $this->byte = 128 * 128 * 100; // 100 Mo
        $this->shmop = null;
        $this->semaphore = sem_get($this->id, 1, $this->mode, 1);
    }

    public function ID($_id=null)
	{
		if (!is_null($_id)){
			if (is_string($_id)) {
				if (file_exists($_id))$this->id=ftok(__FILE__, 't');
				else return false;
			} else if (is_int($_id)){
				$this->id=$_id;
			} else return false;
		}
		return $this->id;
	}

    public function c()
    {
        // Demander le verrou
        sem_acquire($this->semaphore);

        $this->shmop = new Shmop($this->id, 'c', $this->mode, $this->byte);
        $this->shmop->write(serialize([]), 0);

        sem_release($this->semaphore);
    }

    public function n()
    {
        // Demander le verrou
        sem_acquire($this->semaphore);

        $this->c();
        $this->shmop->delete();
        $this->shmop = new Shmop($this->id, 'n', $this->mode, $this->byte);
        $this->shmop->write(serialize([]), 0);

        sem_release($this->semaphore);
    }

    public function a()
    {
        // Demander le verrou
        sem_acquire($this->semaphore);

        $this->shmop = new Shmop($this->id, 'a', $this->mode, $this->byte);
        if (!$this->shmop->isValid()) {
            $this->c();
        }

        sem_release($this->semaphore);
    }

    public function w()
    {
        // Demander le verrou
        sem_acquire($this->semaphore);

        $this->shmop = new Shmop($this->id, 'w', $this->mode, $this->byte);

        sem_release($this->semaphore);
    }

    public function insert($item)
    {
        // Demander le verrou
        sem_acquire($this->semaphore);

        $array = unserialize($this->shmop->read(0, $this->shmop->size()));
        array_unshift($array, [$item]);
        $this->shmop->write(serialize($array), 0);

        sem_release($this->semaphore);
    }

    public function remove()
    {
        // Demander le verrou
        sem_acquire($this->semaphore);

        $array = unserialize($this->shmop->read(0, $this->shmop->size()));
        array_pop($array);
        $this->shmop->write(serialize($array), 0);

        sem_release($this->semaphore);
    }

    public function update($newItem)
    {
        // Demander le verrou
        sem_acquire($this->semaphore);

        $array = unserialize($this->shmop->read(0, $this->shmop->size()));
        $array[0] = $newItem;
        $this->shmop->write(serialize($array), 0);

        sem_release($this->semaphore);
    }

    public function close()
    {
        if ($this->shmop) {
            $this->shmop->close();
            $this->shmop = null;
        }
        sem_remove($this->semaphore);
    }

    public function free()
    {
        if ($this->shmop) {
            $this->shmop->delete();
            $this->shmop->close();
            $this->shmop = null;
        }
        sem_remove($this->semaphore);
    }
}