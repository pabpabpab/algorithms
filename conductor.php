<?php

/*
 * Алгоритм:
 * Чтобы вывести все папки первыми, а потом файлы,
 * помещаю элементы заданной директории в SplPriorityQueue (каждый элемент со своим приоритетом),
 * каждый элемент очереди это массив (имя, путь, время, размер)
 */


class Conductor {
    public $path = '';
    protected $queue = NULL;
    protected $dir = NULL;

    public function __construct($path)
    {
        $this->path = $path;
        $this->queue = new SplPriorityQueue();
        $this->dir = new DirectoryIterator($path);
        $this->dirToQueue($this->dir, $this->queue);
    }

    protected function getUpperPath($currentPath)
    {
        $arr = explode("\\", $currentPath);
        array_pop($arr);
        return implode("\\", $arr);
    }

    protected function getItemPath($item)
    {
        $itemPath = $item->getPathname();
        if ($item->getFilename() === '..') {
            $itemPath = $this->getUpperPath($item->getPath());
            if (empty($itemPath)) {
                $itemPath = $item->getPathname();
            }
        }
        return $itemPath;
    }

    protected function getItemSize($item)
    {
        return ceil($item->getSize()/1024) . " кб";
    }

    protected function getItemTime($item)
    {
        return date("d-m-Y H:i:s", $item->getMTime());
    }

    protected function getItemData($item)
    {
        $itemData = [];
        $itemData['name'] = $item->getFilename();
        if ($item->isDir()) {
            $itemData['folder'] = 1;
            $itemData['path'] = $this->getItemPath($item);
            $itemData['size'] = '';
        } else {
            $itemData['folder'] = 0;
            $itemData['path'] = '';
            $itemData['size'] = $this->getItemSize($item);
        }
        $itemData['time'] = $this->getItemTime($item);
        return $itemData;
    }

    protected function dirToQueue($dir, $queue)
    {
        $directoryPriority = 2000000;
        $filePriority = 1000000;

        foreach ($dir as $item) {
            if ($item->getFilename() === '.') {
                continue;
            }

            $itemData = $this->getItemData($item);

            if ($item->isDir()) {
                $priority = $directoryPriority;
                $directoryPriority--;
            } else {
                $priority = $filePriority;
                $filePriority--;
            }

            $queue->insert($itemData, $priority);
        }
    }

    public function render()
    {
        echo "<h1>" . $this->path . "</h1>";
        echo "<table style='border:0;'>";

        foreach ($this->queue as $item) {
            echo "<tr>";
            echo "<td>";
            if ($item['folder'] === 1) {
                echo "<a href=\"/?path=" . $item['path'] . "\">" . $item['name'] . "</a>";
            } else {
                echo $item['name'];
            }
            echo "</td>";

            echo "<td style='color:#888;padding-left:45px;'>" . $item['time'] . "</td>";
            echo "<td style='color:#888;padding-left:45px;'>" . $item['size'] . "</td>";

            echo"</tr>";
        }

        echo "<table>";
    }
}


$path = $_GET['path'];
if (empty($path)) {
    $path = dirname(__FILE__);
}


$conductor = new Conductor($path);
$conductor->render();
