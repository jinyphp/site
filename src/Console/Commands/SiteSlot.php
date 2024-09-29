<?php
namespace Jiny\Site\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class SiteSlot extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'site:slot {name? : the name of slot} {--active}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'site slot active';

    private $filename;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->filename = "jiny/site/slot";
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $slot = $this->argument('name');
        if($slot) {
            $this->slotActive($slot);
        } else {
            ## 슬롯 리스트
            $this->slotList();
        }



        return 0;
    }

    private function slotActive($slot)
    {
        $conf = str_replace("/",".",$this->filename);
        $rows = config($conf);

        $this->info($slot);

        foreach($rows as $key => &$item) {
            if(isset($item['name']) && $item['name'] == $slot) {
                $item['active'] = 1;
                $this->info('Success : '. $item['name']." activate");
            } else {
                $item['active'] = 0;
            }
        }

        $this->phpSave($rows, $this->filename);
    }

    private function slotList()
    {
        $conf = str_replace("/",".",$this->filename);
        $rows = config($conf);

        foreach($rows as $key => &$item) {
            if(isset($item['active']) && $item['active'] ) {
                $str = "*";
            } else {
                $str = " ";
            }

            $this->info($item['name']." ".$str);


        }
    }

    public function phpSave($rows, $filepath)
    {
        // 저장
        $str = $this->convToPHP($rows);
$file = <<<EOD
<?php
return $str;
EOD;
        // PHP 설정파일명
        $path = $this->filename($filepath);

        // 설정 디렉터리 검사
        $info = pathinfo($path);
        if(!is_dir($info['dirname'])) mkdir($info['dirname'],0755, true);

        file_put_contents($path, $file);
    }

    public function convToPHP($form, $level=1)
    {
        $str = "[\n"; //초기화
        $lastKey = array_key_last($form);

        foreach($form as $key => $value) {
            for($i=0;$i<$level;$i++) $str .= "\t";

            if(is_array($value)) {
                $str .= "'$key'=>".''.$this->convToPHP($value,$level+1).'';
            } else {
                $str .= "'$key'=>".'"'.addslashes($value).'"';
            }

            if($key != $lastKey) $str .= ",\n";
        }

        $str .= "\n";

        if($level>1) {
            for($i=0;$i<$level-1;$i++) $str .= "\t";
        }

        $str .= "]";

        return $str;
    }


    /**
     * 설정 파일명 얻기
     */
    private function filename($filename)
    {
        $path = config_path().DIRECTORY_SEPARATOR.$filename.".php";
        return $path;
    }



}
