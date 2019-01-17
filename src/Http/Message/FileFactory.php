<?php

namespace Zapheus\Http\Message;

class FileFactory
{
    protected $error = UPLOAD_ERR_OK;

    protected $file = '';

    protected $name = '';

    public function error($error)
    {
        $this->error = $error;

        return $this;
    }

    public function file($file)
    {
        $this->file = $file;

        return $this;
    }

    public function make()
    {
        return new File($this->file, $this->name, $this->error);
    }

    public function name($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Parses the $_FILES into multiple \File instances.
     *
     * @param  array $uploaded
     * @param  array $files
     * @return \Zapheus\Http\Message\FileInterface[]
     */
    public function normalize(array $uploaded, $files = array())
    {
        foreach ($this->diverse($uploaded) as $name => $file)
        {
            $items = array();

            foreach ($file['name'] as $key => $value)
            {
                $this->file = $file['tmp_name'][$key];

                $this->name = $file['name'][$key];

                $this->error = $file['error'][$key];

                array_push($items, $this->make());
            }

            $files[$name] = $items;
        }

        return $files;
    }

    /**
     * Diverse the $_FILES into a consistent result.
     *
     * @param  array $uploaded
     * @return array
     */
    protected function diverse(array $uploaded)
    {
        $result = array();

        foreach ($uploaded as $file => $item)
        {
            foreach ($item as $key => $value)
            {
                $diversed = (array) $value;

                $result[$file][$key] = $diversed;
            }
        }

        return $result;
    }
}
