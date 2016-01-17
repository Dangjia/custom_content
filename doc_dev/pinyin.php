use Overtrue\Pinyin\Pinyin;
	
	//获取拼音
	echo Pinyin::trans('带着希望去旅行，比到达终点更美好');
	// dài zhe xī wàng qù lǔ xíng bǐ dào dá zhōng diǎn gèng měi hǎo
	
	//获取首字母
	echo Pinyin::letter('带着希望去旅行，比到达终点更美好');
	// d z x w q l x b d d z d g m h
	
	//当前也可以两个同时获取
	echo Pinyin::parse('带着希望去旅行，比到达终点更美好');
	// output:
	// array(
	//  'src'    => '带着希望去旅行，比到达终点更美好',
	//  'pinyin' => 'dài zhe xī wàng qù lǔ xíng bǐ dào dá zhōng diǎn gèng měi hǎo',
	//  'letter' => 'd z x w q l x b d d z d g m h',
	// );
	
	// 加载自定义补充词库
	$appends = array(
			'冷' => 're4',
	);
	Pinyin::appends($appends);
	echo Pinyin::trans('冷');