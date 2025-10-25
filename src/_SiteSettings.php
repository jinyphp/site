<?php
namespace Jiny\Site;

class SiteSettings
{
    private static $Instance;

    /**
     * 싱글턴 인스턴스를 생성합니다.
     */
    public static function instance($jname)
    {
        if (!isset(self::$Instance)) {
            // 자기 자신의 인스턴스를 생성합니다.
            self::$Instance = new self();

            // json 정보를 읽어 옵니다.
            self::$Instance->load($jname);

            return self::$Instance;
        } else {
            // 인스턴스가 중복
            return self::$Instance;
        }
    }


    public $info = [];

    private function load($jname) {

        $path = resource_path('www');
        if(!is_dir($path)) mkdir($path);

        $filename = $path.DIRECTORY_SEPARATOR.$jname.".json";
        if (file_exists($filename)) {
            $rules = json_decode(file_get_contents($filename), true);

            foreach ($rules as $key => $value) {
                $this->info[$key] = $value;
            }
        }

        return $this;
    }

    public function get($key=null)
    {
        if($key) {
            if(isset($this->info[$key])) {
                return$this->info[$key];
            }
        }

        return false;
    }



}
