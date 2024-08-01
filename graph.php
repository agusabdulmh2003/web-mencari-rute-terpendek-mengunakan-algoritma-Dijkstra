<?php

class Graph {
    private $matrix = [];
    private $size;
    private $distances = [];
    private $previous = [];
    private $nodes = [];
    private $kecamatan = [
        'Pemalang', 'Taman', 'Petarukan', 'Bodeh'
    ];
    // di isi nama tempat 
    public function __construct($fileName) {
        $this->loadGraphFromFile($fileName);
    }

    private function loadGraphFromFile($fileName) {
        $file = fopen($fileName, 'r');
        $this->size = (int)fgets($file);
        for ($i = 1; $i <= $this->size; $i++) {
            $this->matrix[$i] = array_map('intval', explode(' ', fgets($file)));
            foreach ($this->matrix[$i] as &$value) {
                if ($value < 0) {
                    $value = PHP_INT_MAX;
                }
            }
        }
        fclose($file);
    }

    public function dijkstra($start) {
        $this->distances = array_fill(1, $this->size, PHP_INT_MAX);
        $this->previous = array_fill(1, $this->size, -1);
        $this->distances[$start] = 0;
        $this->nodes = range(1, $this->size);
    // mencari rute pendek
        while (!empty($this->nodes)) {
            $minNode = $this->getMinDistanceNode();
            if ($minNode === null) {
                break;
            }
            foreach ($this->matrix[$minNode] as $neighbor => $cost) {
                if ($cost !== PHP_INT_MAX && $cost > 0) {
                    $alt = $this->distances[$minNode] + $cost;
                    if ($alt < $this->distances[$neighbor]) {
                        $this->distances[$neighbor] = $alt;
                        $this->previous[$neighbor] = $minNode;
                    }
                }
            }
        }
    }

    private function getMinDistanceNode() {
        $min = PHP_INT_MAX;
        $minNode = null;
        foreach ($this->nodes as $node) {
            if ($this->distances[$node] < $min) {
                $min = $this->distances[$node];
                $minNode = $node;
            }
        }
        if ($minNode !== null) {
            $this->nodes = array_diff($this->nodes, [$minNode]);
        }
        return $minNode;
    }

    public function printPath($end) {
        $path = [];
        $node = $end;
        while ($node !== -1) {
            array_unshift($path, $node);
            $node = $this->previous[$node];
        }

        if ($this->distances[$end] == PHP_INT_MAX) {
            echo "<p>Lintasan tidak ditemukan dari kecamatan " . $this->kecamatan[$_POST['start']] . " ke kecamatan " . $this->kecamatan[$end] . "</p>";
        } else {
            $pathNames = array_map(function($node) {
                return $this->kecamatan[$node];
            }, $path);
            echo "<p>Lintasan terpendek dari kecamatan " . $this->kecamatan[$_POST['start']] . " ke kecamatan " . $this->kecamatan[$end] . ": " . implode(' -> ', $pathNames) . "</p>";
            echo "<p>Jarak: " . $this->distances[$end] . "</p>";
        }
    }
}
?>
