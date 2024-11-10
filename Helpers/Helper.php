<?php

use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

class Helper
{
    public static function getAppName(String|Array $excludeText='API') :String
    {
        $appName = config('app.name');

        return empty($excludeText)
            ? $appName
            : str_replace($excludeText, '', $appName)
        ;
    }

    /**
     * Gets a value from the session if session has that
     *
     * @param string $sessionKey Session key to get value
     * @return mixed        If session has that data then that data or false
     */
    public static function getFromSession($sessionKey) :mixed
    {
        if (Session::has($sessionKey)) {

            return Session::get($sessionKey);
        }

        return false;
    }

    /**
     * Pull (get then forget) a value from the session if session has that
     *
     * @param string $sessionKey Session key to get value
     * @return mixed        If session has that data then that data or false
     */
    public static function pullFromSession($sessionKey) :mixed
    {
        if (Session::has($sessionKey)) {
            return Session::pull($sessionKey);
        }

        return false;
    }

    public static function flashToSession($data, $name = 'notification') :void
    {
        Session::flash($name, $data);
    }

    public static function putToSession($data, $name = 'notification') :void
    {
        Session::put($name, $data);
    }

    /**
     * Gets error message from a form submission error
     *
     * @param Collection $errors
     * @param string     $name field name under validation
     * @return    string    mixed
     */
    public static function getFormError(Collection $errors, string $name) :string
    {

        if ($errors->has($name)) {

            return $errors->first($name);
        }

        return '';
    }

    /**
     * Checks if any of the listed errors exists int he errors array
     *
     * @param       $errors $errors
     * @param array $errorNames
     * @return int
     */
    public static function ifErrorsHas($errors, array $errorNames) :int
    {
        foreach ($errorNames as $name) {

            if ($errors->has($name)) {

                return 1;
            }
        }

        return 0;
    }

    /**
     * Returns the $print if (form)errors has $errorName
     * otherwise false
     *
     * @param Collection $errors    form errors object
     * @param string     $errorName form (element) name
     * @param mixed      $print     printable
     * @return mixed
     */
    public static function onError(Collection $errors, string $errorName, mixed $print) :mixed
    {
        return ($errors->has($errorName)) ? $print : false;
    }

    /**
     * If route(name) matches the given route
     * then returns #param2
     *
     * @param string|array $routeName Named route's name or array or route names
     * @param mixed       $print     string to print
     * @return string
     */
    public static function ifRoute(string|array $routeName, mixed $print) :string
    {

        if (is_array($routeName)) {

            foreach ($routeName as $rn) {

                if (Route::is($rn)) {
                    return $print;
                }
            }
        } else if (Route::is($routeName)) {

            return $print;
        }

        return '';
    }

    /**
     * If current page url matches the given url
     *
     * @param string $url   link url
     * @param string $print print content if url matches (optional)
     * @return mixed
     */
    public static function ifUrl(string $url, mixed $print = null) :mixed
    {

        if (Request::is($url)) {

            return (empty($print)) ? true : $print;
        }

        return false;
    }

    /**
     * Prints $print if current route is not the
     * provided (named)route $routeName
     *
     * @param string|array $routeName
     * @param string|int        $print Printable
     * @return bool|int|string
     */
    public static function ifRouteIsNot(string|array $routeName, string|int $print) :bool|int|string
    {

        if (is_array($routeName)) {

            foreach ($routeName as $rn) {

                if (!Route::is($rn)) {

                    return $print;
                }
            }
        } else {

            if (!Route::is($routeName)) {

                return $print;
            }
        }

        return false;
    }

    /**
     * Returns an time and date string representing elapsed time
     *
     * @param string $sqlTimeStamp the time stamp to parse, like: 2017-10-09 13:22:44
     * @param array  $format       sample format: '%y Year, %m Months and %d Days %i Minuites %s Seconds Ago'
     * @return string         sample output: 10 Year, 7 Months and 22 Days 16 Minuites 42 Seconds Ago
     */
    public static function getElapsedTime(string $sqlTimeStamp, array $format = ['y', 'm', 'd', 'h', 'i', 's']) :string
    {
        $elapsedTime = Carbon\Carbon::parse($sqlTimeStamp);

        $Age = '';


        foreach ($format as $f) {

            if (($value = $elapsedTime->diff(Carbon\Carbon::now())->format("%{$f}")) > 0) {

                switch ($f) {

                    case 'y':
                        $word = ($value > 1) ? ' Years ' : ' Year ';
                        $Age .= $value . $word;
                        break;

                    case 'm':
                        $word = ($value > 1) ? ' Months ' : ' Month ';
                        $Age .= $value . $word;
                        break;

                    case 'd':
                        $word = ($value > 1) ? ' Days ' : ' Day ';
                        $Age .= $value . $word;
                        break;

                    case 'h':

                        $word = ($value > 1) ? ' Hours ' : ' Hour ';
                        $Age .= $value . $word;
                        break;

                    case 'i':
                        $word = ($value > 1) ? ' Minutes ' : ' Minute ';
                        $Age .= $value . $word;
                        break;

                    case 's':
                        $word = ($value > 1) ? ' Seconds ' : ' Second ';
                        $Age .= $value . $word;
                        break;

                    default:

                        break;
                }
            }
        }

        return $Age;
    }

    /**
     * Replace white space to dash (-)
     *
     * @param string $string
     * @return string
     */
    public static function spaceToDash(string$string) :string
    {
        return str_replace(' ', '-', trim($string));
    }

    /**
     * Replace $replace with $replaceWith
     *
     * @param string $string
     * @param string $replace
     * @param string $replaceWith
     * @return string
     */
    public static function dashToSpace(string $string, $replace = '-', $replaceWith = ' ') :string
    {
        return str_replace($replace, $replaceWith, trim($string));
    }

    /**
     * Adds suffix to numbers
     * like 1 to 1st
     *
     * @param $number
     * @return string
     */
    public static function addNumberSuffix(int|string $number) :string
    {

        switch ($number) {

            case $number == 1:
                return $number . 'st';
                break;

            case $number == 2:
                return $number . 'nd';
                break;

            case $number == 3:
                return $number . 'rd';
                break;

            default:
                return $number . 'th';
                break;
        }
    }

    /**
     * Checks if current user is logged in or not
     *
     * @param null $guard
     * @return bool
     */
   public static function isLoggedIn($guard = null) :bool
   {
       return Auth::guard($guard)->check();
   }

    /**
     * Gets currently authenticated user
     * Returns false or user if current user is authenticated
     *
     * @return Authenticatable
     */
    public static function getAuthUser() :Authenticatable|false
    {
        if (isLoggedIn()) {

            return Auth::user();

        } else {

            return false;
        }

    }

    /**
     * Formats given time string or current time
     * if no parameters passed & returns it
     *
     * @param string $timeString
     * @return string
     */
    public static function formatTime(string $timeString = '') :string
    {
        $format = 'M d, Y @ h:i a';

        if (!empty($timeString)) {
            $t = date($format, strtotime($timeString));
        } else {
            $t = date($format);
        }

        return $t;
    }

    /**
     * Secure nl2br
     *
     * Sanitize string & converts new line character to tab
     * Converts html chars & strip all html tags
     *
     * @param string $string
     * @return string
     */
    public static function sNl2br(string $string) :string
    {
        // Convert special characters to HTML entities
        $round1 = htmlspecialchars($string, ENT_QUOTES | ENT_HTML5);

        // Strip HTML and PHP tags
        $round2 = strip_tags($round1);

        return nl2br($round2);
    }

    /**
     * Primary purpose is add 's' / 'es' to the print word
     * but it can be used wisely in other situations too.
     *
     * @param mixed  $int
     * @param string $word
     * @param string $add
     * @return string
     */
    public static function addPlural(mixed $int, string $word, string $add = 's') :string
    {

        if ($int > 1) {

            return $word . $add;
        }

        return $word;
    }

    /**
     * Returns SQL formatted current time
     *
     * @return string
     */
    public static function currentSqlFormattedTime() :string
    {
        return strftime('%F %T');
    }

    /**
     * Formats a given time to sql format
     *
     * @param string $timeString
     * @return string
     */
    public static function formatDateTimeSQL(string $timeString = 'now') :string
    {
        return strftime('%F %T', strtotime($timeString));
    }

    /**
     * Formats given time to the specified format
     * (24-07-18 @ 4:32 PM)
     * if dateOnly is true then this will output only date
     *
     * if format is given then formats time according to it
     *
     * @param string      $timeString
     * @param bool|string $dateOnly
     * @param bool|string $format
     * @return string
     */
    public static function formatDateTime(string $timeString, bool $dateOnly = false, bool|string $format = false) :string
    {
        $format = ($dateOnly) ? '%F' : (($format) ?: '%F @ %I:%M %p');

        return strftime($format, strtotime($timeString));
        // return date('Y-m-d @ h:i A', strtotime($timeString));
    }

    /**
     * Formats given time to the specified format
     * (24-07-18 @ 4:32 PM)
     * if dateOnly is true then this will output only date
     *
     * if format is given then formats time according to it
     *
     * @param string|int  $timeStamp
     * @param bool|string $dateOnly
     * @param bool|string $format
     * @return string
     */
    public static function formatDateTimeFromStamp(string|int $timeStamp, $dateOnly = false, $format = false) :string
    {

        $format = ($dateOnly) ? '%F' : (($format) ?: '%F @ %I:%M %p');

        return strftime($format, $timeStamp);
    }

    public static function formatMonthDate(string $timeString, bool $shortMonth = false, bool $monthOnly = false) :string
    {

        $format = ($monthOnly) ? (($shortMonth) ? '%b' : '%B') : ((($shortMonth) ? '%b' : '%B') . ', %d');

        return strftime($format, strtotime($timeString));
    }

    /**
     * Formats given time to the specified format
     * (4:32 PM)
     *
     * @param string $timeString
     * @return string
     */
    public static function formatTimeOnly(string $timeString) :string
    {

        $format = '%I : %M %p';

        return strftime($format, strtotime($timeString));
    }

    /**
     * Returns past or future date based on supplied parameters
     *
     * If $past is provided & $future is empty
     * then the past date is returned or vice versa
     *
     * ** only pass one param at a time & keep other as false
     *    if both parameters are passed then only past date will be returned
     *    if both parameters are false then current date is returned
     *
     * @param int  $pastYears
     * @param bool $futureYears
     * @return string
     */
    public static function yearPastOrFuture(int $pastYears, bool $futureYears = false) :string
    {

        $currentDate = \Carbon\Carbon::createFromTime();

        if ($pastYears) {

            $currentDate->subYear($pastYears);
            $yearsDate = $currentDate->toDateString();
        } else {

            $currentDate->addYear($futureYears);
            $yearsDate = $currentDate->toDateString();
        }

        return $yearsDate;
    }

    /**
     * Extracts permission subject from permission
     * @param string $permissionName
     * @return string
     * @throws Exception
     */
    public static function getPermissionSubject(string $permissionName) :string
    {
        $offset = strpos($permissionName, '-');
        $subject = substr($permissionName, 0, $offset);

        if (!$subject) {
            throw new Exception("Permission: {$permissionName} doesn't have subject");
        }

        return $subject;
    }

    public static function groupPermissionBySubject(Collection $permissions) :Collection
    {
        $groupByKey = 'subject';

        $permissionGroup = $permissions->map(function($item) use($groupByKey) {
            $item->$groupByKey = self::getPermissionSubject($item->name);
            $item->slug = array_keys($item->slug);

            return $item;
        })->groupBy($groupByKey);

        return $permissionGroup;
    }

    public static function getSetting(string|array $key, bool $valueOnly=true) :Setting|Collection|stdClass|string|bool|null
    {
        // if multiple setting wanted
        if (is_array($key)) {
            $settings = Setting::whereIn('key', $key)->get();

            if (!$valueOnly) {
                return $settings->toObject('key');
            }

            return $settings->flatMap(fn($s) => [$s->key => $s->value])->toObject();
        }


        // if single setting wanted
        $setting = Setting::where('key', $key)->first();

        if (!$valueOnly) {
            return $setting;
        }

        return $setting->value ?? $setting;
    }

    public static function printIfSettingIs(string $settingKey, string|int|bool $settingValue, string|int $print) :int|string
    {
        $val = self::getSetting($settingKey);
        return ($val === $settingValue) ? $print : '';
    }

    public static function formatDbTime($timeString, $encode=true) :string
    {
        $encodeFormat = '%H:%M:%S'; // 16:35:56
        $decodeFormat = '%I:%M %p'; // 11:35 PM

        $format = $encode ? $encodeFormat : $decodeFormat;

        return strftime($format, strtotime($timeString));
    }


    /**
     * @param array $data
     * @param string $message
     * @param bool $status
     * @return array
     */
    public static function formatResponse(mixed $data = [], string $message = '', bool $status=true) : array
    {
        return [
            'status' => $status,
            'data' => $data,
            'message' => $message,
        ];
    }

    public static function sendResponse(mixed $data=[], string $message='', bool $status=true, int $statusCode=200) :\Illuminate\Http\JsonResponse
    {
        return response()->json(self::formatResponse($data, $message, $status), $statusCode);
    }

    public static function getCardPaymentVendorConfig() :array
    {
        $stage = config('app.application.payment.cardPayment.stage');
        $vendor = config('app.application.payment.cardPayment.vendor');

        $config = config("app.application.payment.cardPayment.vendorConfig.{$vendor}.{$stage}");

        return $config;
    }

    /**
     * @throws RuntimeException
     */
    public static function ddCors(...$vars) :void
    {

        $referer = $_SERVER['HTTP_REFERER'] ?? false;

        if (!$referer) {
            throw new RuntimeException('Referer header is required');
        }

        $origin = substr($referer, 0, -1);

        header("Access-Control-Allow-Origin: {$origin}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Allow-Methods: *');
        header('Access-Control-Allow-Headers: *');
        // header('Access-Control-Max-Age: 86400');

        header('Content-Type: text/html');

        dd(...$vars);

    }

    public static function ddCorsJson(...$vars) :void
    {

        $referer = $_SERVER['HTTP_REFERER'];
        $origin = substr($referer, 0, -1);

        header("Access-Control-Allow-Origin: {$origin}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Allow-Methods: *');
        header('Access-Control-Allow-Headers: *');
        // header('Access-Control-Max-Age: 86400');

        header('Content-Type: application/json');

        die(json_encode($vars, JSON_THROW_ON_ERROR));
    }

    /**
     * Converts time from 12 to 24 hours,
     * Only converts time string
     *
     * @param string $timeSting the time sting to convert
     * @param bool   $asObject  if true returns hour,minute & seconds separately as object
     * @param string $format    input time string format (as php date)
     * @return string|object
     */
    public static function convertTimeTo24Hour(string $timeSting, bool $asObject=false, string $format='h:i a') :string|object
    {
        $time = Carbon::createFromFormat($format, $timeSting);

        $format24Hour = 'G:i a';

        if ($asObject) {
            return (object) [
                'h' => $time->hour,
                'm' => $time->minute,
                's' => $time->second,
            ];
        }

        return $time->format($format24Hour);
    }

    public static function mergeDateTime(string $dateString, string $timeSting, bool $is24hr = false) :Carbon
    {
        // create from date
        $timeObj = Carbon::createFromTimestamp(strtotime($dateString));

        // merging time with date
        $format = $is24hr
            ? config('app.application.formats.time24') ?? 'H:i:s'
            : config('app.application.formats.time') ?? 'h:i a'
        ;

        $time = self::convertTimeTo24Hour($timeSting, true, $format);

        $timeObj->setHours($time->h)->setMinute($time->m)->setSecond($time->s);

        return $timeObj;
    }

    /**
     * Moves uploaded files into specified disk > directory
     * @param UploadedFile $file
     * @param string       $folderName
     * @param string       $diskName
     * @param string|null  $fileName
     * @param string|null  $existingFileNameForDelete
     * @return string
     */
    public static function moveUploadedFile(
        mixed $file,
        string $folderName,
        string $fileName = null,
        string $diskName = 'public',
        string $existingFileNameForDelete = null
    ): string
    {
        // return the file if this is not a valid file
        if (!($file instanceof UploadedFile)) {
            return $file;
        }

        // generate unique name

        if (!$fileName) {
            $currentDate = now();
            $slugify = Str::slug($currentDate, '-');
            $fileName = $slugify . '.' . $file->getClientOriginalExtension();
        }

        $diskDrive = Storage::disk($diskName);

        // Check if settings folder exist or not
        if (!$diskDrive->exists($folderName)) {
            $diskDrive->makeDirectory($folderName);
        }


        // If delete existing requested

        $existingFilePath = "{$folderName}/{$existingFileNameForDelete}";

        if ($existingFileNameForDelete && $diskDrive->exists($existingFilePath)) {
            $diskDrive->delete($existingFilePath);
        }

        // Store File in disk path

        $filePath = "{$folderName}/";

        $diskDrive->putFileAs($filePath, $file, $fileName);

        return $fileName;
    }


    public static function deleteFile(string $fileName, string $path, string $disk = 'public'): void
    {
        if (Storage::disk($disk)->exists($path . '/' . $fileName)) {
            Storage::disk($disk)->delete($path . '/' . $fileName);
        }
    }

    public static function makeOrderNumber(int $orderId) :string
    {
        return str_pad($orderId, 4, '0', STR_PAD_LEFT);
    }

    public static function calculateOrderPoints(int $orderTotal) :int
    {
        $pointPercentage = config('app.application.point.earnPercentage');
        $moneyRate = config('app.application.point.moneyRate');

        // get point earn percentage of money
        $moneyForPoint = ($orderTotal * $pointPercentage) / 100;

        // convert money to point
        return round($moneyForPoint * $moneyRate);
    }

    public static function orderPointsToMoney(int $points) :float
    {
        $moneyRate = config('app.application.point.moneyRate');

        $money = ($points / $moneyRate);

        return number_format($money, 2);
    }

    public static function errorMsg(string $errorMsg, string $customMsg = 'Something went wrong, Please try again!') :string
    {
        return config('app.debug') ? $errorMsg : $customMsg;
    }

    public static function getCalledClassMethod(bool $fullPath = false, bool $asObj=false) :string
    {
        $backtrace = debug_backtrace()[1];

        $class = $backtrace['class'];
        $method = $backtrace['function'];

        if ($asObj) {
            return (object) [
                'class' => $class,
                'method' => $class,
            ];
        }

        return $fullPath ? "$class::$method" : $method;
    }

    public static function dateFormatAlt($date, $format = 'd.m.Y') :string
    {
        return date($format, strtotime($date));
    }
}
