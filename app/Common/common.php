<?php
/*
* 公用的方法  返回json数据，进行信息的提示
* @param $status 状态
* @param string $msg 提示信息
* return array $data 返回数据
*/
function echojson($msg='success',$status=1,$data=array()){
    return Response::json(
        [
            'msg'=>$msg,
            'status'=>$status,
            'data'=>$data
        ]
    );
}
/*
 * 获取小说分类名称
 * @param $type 类型ID
 * return 中文类型名称
 * */
function get_bookType($type){
        switch ($type){
            case 0:
                return [
                    array('id'=>1,'name'=>'玄幻小说'),
                    array('id'=>2,'name'=>'修真小说'),
                    array('id'=>3,'name'=>'都市小说'),
                    array('id'=>4,'name'=>'穿越小说'),
                    array('id'=>5,'name'=>'网游小说'),
                    array('id'=>6,'name'=>'科幻小说')
                ];
            case 1:
                return '玄幻小说';
            case 2:
                return '修真小说';
            case 3:
                return '都市小说';
            case 4:
                return '穿越小说';
            case 5:
                return '网游小说';
            case 6:
                return '科幻小说';
            default:
                return '其他小说';

        }
}

/*
 * 获取小说章节及文章内容
 * @param book_url 小说url
 * @param type 返回的数据类型  1 带章节内容返回  2 返回章节列表
 * return array
 * */
function get_bookData($book_url,$type){
    $xs_capter_list = [];
    $xs_content_list = [];
    set_time_limit(0);//0表示不限时
    $file = fopen($book_url, "r");
    $i = 0;//行数
    $j = 1; //章节数
    $content = '';
    $chaptertitle ='';
    //输出文本中所有的行，直到文件结束为止。
    while(true) {
        if(feof($file)){
            //文章结尾
            if($content!='' && $chaptertitle!=''){
                $content = strtr($content,["\r\n" => '<br>']);
                $xs_content_list[] = $content;
                //成功后
                break;
            }
            break;
        }else{
            $now = fgets($file);
            $now = mb_convert_encoding($now,'UTF-8','UTF-8,GBK,GB2312,BIG5');//使用该函数对结果进行转码
            //var_dump($now);
            if(strpos($now,'第')!==FALSE and strpos($now,'章')!==FALSE){
                //判断上一层循环
                if($content!='' && $chaptertitle!=''){
                    //执行插入操作
                    $content = strtr($content,["\r\n" => '<br>']);
                    $xs_content_list[] = $content;
                    //成功后
                    $content = '';
                    $chaptertitle = strtr($now,["\r\n" => '']);
                    $j++;
                }else{
                    $content .= $now;
                    $chaptertitle = strtr($now,["\r\n" => '']);
                }
                $xs_capter_list[] = $chaptertitle;
            }else{
                $content .= $now;
            }
        }
        $i++;
    }
    if($type == 1){
        $chapter_num = 0;
        foreach($xs_capter_list as $key=>$v){
            $v = preg_replace('/[\s]/', '', $v);
            if(mb_strlen($xs_content_list[$key])>100){
                $chapter[$chapter_num]['content'] = $xs_content_list[$key];
                $chapter[$chapter_num]['total'] = mb_strlen($xs_content_list[$key]);
                $chapter[$chapter_num]['capter'] = $v;
                $chapter_num++;
            }
        }
        return $chapter;
    }elseif($type == 2){
        return $xs_capter_list;
    }
}

/*
 * 无限极分类
 * @param $array 二维数组
 * return array
 * */
function getTree($array, $pid =0, $level = 0){
    //声明静态数组,避免递归调用时,多次声明导致数组覆盖
    static $list = [];
    foreach ($array as $key => $value){
        //第一次遍历,找到父节点为根节点的节点 也就是pid=0的节点
        if ($value['pid'] == $pid){
            //父节点为根节点的节点,级别为0，也就是第一级
            $value['level'] = $level;
            //把数组放到list中
            $list[] = $value;
            //把这个节点从数组中移除,减少后续递归消耗
            unset($array[$key]);
            //开始递归,查找父ID为该节点ID的节点,级别则为原级别+1
            getTree($array, $value['id'], $level+1);
        }
    }
    return $list;
}
/*
 * 无限极层级分类
 * @param $array 二维数组
 * return array
 * */
function getTree2($a,$pid=0){
    $tree = array();                                //每次都声明一个新数组用来放子元素
    foreach($a as $v){
        if($v['pid'] == $pid){                      //匹配子记录
            $v['children'] = getTree2($a,$v['id']); //递归获取子记录
            if($v['children'] == null){
                unset($v['children']);             //如果子元素为空则unset()进行删除，说明已经到该分支的最后一个元素了（可选）
            }
            $tree[] = $v;                           //将记录存入新数组
        }
    }
    return $tree;                                  //返回新数组
}

/*
 * 转换金额的中文大写
 * @param $num float 金额
 * return string
 * */
function num_to_rmb($num){
    $c1 = "零壹贰叁肆伍陆柒捌玖";
    $c2 = "分角元拾佰仟万拾佰仟亿";
    //精确到分后面就不要了，所以只留两个小数位
    $num = round($num, 2);
    //将数字转化为整数
    $num = $num * 100;
    if (strlen($num) > 10) {
        return "金额太大，请检查";
    }
    $i = 0;
    $c = "";
    while (1) {
        if ($i == 0) {
            //获取最后一位数字
            $n = substr($num, strlen($num)-1, 1);
        } else {
            $n = $num % 10;
        }
        //每次将最后一位数字转化为中文
        $p1 = substr($c1, 3 * $n, 3);
        $p2 = substr($c2, 3 * $i, 3);
        if ($n != '0' || ($n == '0' && ($p2 == '亿' || $p2 == '万' || $p2 == '元'))) {
            $c = $p1 . $p2 . $c;
        } else {
            $c = $p1 . $c;
        }
        $i = $i + 1;
        //去掉数字最后一位了
        $num = $num / 10;
        $num = (int)$num;
        //结束循环
        if ($num == 0) {
            break;
        }
    }
    $j = 0;
    $slen = strlen($c);
    while ($j < $slen) {
        //utf8一个汉字相当3个字符
        $m = substr($c, $j, 6);
        //处理数字中很多0的情况,每次循环去掉一个汉字“零”
        if ($m == '零元' || $m == '零万' || $m == '零亿' || $m == '零零') {
            $left = substr($c, 0, $j);
            $right = substr($c, $j + 3);
            $c = $left . $right;
            $j = $j-3;
            $slen = $slen-3;
        }
        $j = $j + 3;
    }
    //这个是为了去掉类似23.0中最后一个“零”字
    if (substr($c, strlen($c)-3, 3) == '零') {
        $c = substr($c, 0, strlen($c)-3);
    }
    //将处理的汉字加上“整”
    if (empty($c)) {
        return "零元整";
    }else{
        return $c . "整";
    }

}

/*
 * 判断是否是移动端访问
 * return bool
 * */
function isMobile()
{
    // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
    if (isset ($_SERVER['HTTP_X_WAP_PROFILE'])) {
        return TRUE;
    }
    // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
    if (isset ($_SERVER['HTTP_VIA'])) {
        return stristr($_SERVER['HTTP_VIA'], "wap") ? TRUE : FALSE;// 找不到为flase,否则为TRUE
    }
    // 判断手机发送的客户端标志,兼容性有待提高
    if (isset ($_SERVER['HTTP_USER_AGENT'])) {
        $clientkeywords = array(
            'mobile',
            'nokia',
            'sony',
            'ericsson',
            'mot',
            'samsung',
            'htc',
            'sgh',
            'lg',
            'sharp',
            'sie-',
            'philips',
            'panasonic',
            'alcatel',
            'lenovo',
            'iphone',
            'ipod',
            'blackberry',
            'meizu',
            'android',
            'netfront',
            'symbian',
            'ucweb',
            'windowsce',
            'palm',
            'operamini',
            'operamobi',
            'openwave',
            'nexusone',
            'cldc',
            'midp',
            'wap'
        );
        // 从HTTP_USER_AGENT中查找手机浏览器的关键字
        if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
            return TRUE;
        }
    }
    if (isset ($_SERVER['HTTP_ACCEPT'])) { // 协议法，因为有可能不准确，放到最后判断
        // 如果只支持wml并且不支持html那一定是移动设备
        // 如果支持wml和html但是wml在html之前则是移动设备
        if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== FALSE) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === FALSE || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
            return TRUE;
        }
    }
    return FALSE;
}

/*
 * 获取客户端请求的IP地址
* @param string $proxy_override, [true|false], 是否优先获取从代理过来的地址
* @return string
*/
function get_client_ip_from_ns($proxy_override = false)
{
    if ($proxy_override) {
        /* 优先从代理那获取地址或者 HTTP_CLIENT_IP 没有值 */
        $ip = empty($_SERVER["HTTP_X_FORWARDED_FOR"]) ? (empty($_SERVER["HTTP_CLIENT_IP"]) ? NULL : $_SERVER["HTTP_CLIENT_IP"]) : $_SERVER["HTTP_X_FORWARDED_FOR"];
    } else {
        /* 取 HTTP_CLIENT_IP, 虽然这个值可以被伪造, 但被伪造之后 NS 会把客户端真实的 IP 附加在后面 */
        $ip = empty($_SERVER["HTTP_CLIENT_IP"]) ? NULL : $_SERVER["HTTP_CLIENT_IP"];
    }
    if (empty($ip)) {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    /* 真实的IP在以逗号分隔的最后一个, 当然如果没用代理, 没伪造IP, 就没有逗号分离的IP */
    if ($p = strrpos($ip, ",")) {
        $ip = substr($ip, $p+1);
    }
    return trim($ip);
}
/*
 * 检查客户端从是否从sanye666域名下 发送的请求
 * @param bool   $restrict  是否进行严格的查检, 此方式为用正则对host进行匹配
 * @param string $allow       允许哪些 referer 过来请求
 * @return true / false       在允许的列表内返回true
 *
 */
function check_client_referer($restrict = true, $allow = '.sanye666.top')
{
    $referer = isset($_SERVER['HTTP_REFERER']) ? trim($_SERVER['HTTP_REFERER']) : null;
    if (empty($referer)) { return true;    } /* 空的 referer 直接允许 */

    if ($restrict) {
        /* 更加严格的查检, 此值为true时, allow 可以输入正则来匹配 */
        $url = parse_url($referer);
        /* host 为空时直接返回不false */
        if (empty($url['host'])) { return false; }
        /* 将正则中的.替换掉为\.真正匹配.再进行匹配 */
        $allow = '/'.str_replace('.', '\.', $allow).'/';
        return 0 < preg_match($allow, $url['host']);
    }
    return false !== strpos($referer, $allow);
}
