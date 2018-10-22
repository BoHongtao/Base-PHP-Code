<?php
/*
 * ��ҳ������
 */
	class Page{
		/* 
		 *	��ҳ������ͨ�����ݲ���һ�ѷ�ҳ����
		 * @param1 int $counts���ܼ�¼��
		 * @param2 string $controller��Ҫ���ʵĿ�����
		 * @param3 string $action������
		 * @param4 string $plat��ƽ̨
		 * @param5 int $pagecount = 5��ÿҳ��ʾ��¼
		 * @param6 int $page = 1����ǰҳ��
		*/
		public static function getPageString($counts,$controller,$action,$plat,$pagecount = 5,$page = 1){
			//��������
			$pages = ceil($counts / $pagecount);
			$url = 'index.php?p=' . $plat . '&m=' . $controller . '&a=' . $action;
			//������һҳ����һҳ
			$prev = $page > 1 ? $page - 1 : 1;
			$next = $page < $pages ? $page + 1 : $pages;


			//��ҳ�ַ���
			$pagestring = '';

			//ƴ�������
			if($page > 1) $pagestring .= "<a href='{$url}&page={$prev}'>��һҳ</a>";

			//����ƴ��
			if($pages <= 10){
				for($i = 1;$i <= $pages;$i++){
					$pagestring .= "<a href='{$url}&page={$i}'>{$i}</a>";
				}

				//�жϵ�ǰҳ���Ƿ��������һ��
				if($page != $pages) $pagestring .= "<a href='{$url}&page={$next}'>��һҳ</a>";

				//��������
				return $pagestring;
			}

			//��ǰ��ҳ��һ������10ҳ
			if($page > 6){

				//���������4ҳ
				if($page + 4 <= $pages){
					for($i = $page - 5;$i <= $page + 4; $i++){
						$pagestring .= "<a href='{$url}&page={$i}'>{$i}</a>";
					}
				}else{
					for($i = $pages - 9;$i <= $pages; $i++){
						$pagestring .= "<a href='{$url}&page={$i}'>{$i}</a>";
					}
				}
			}else{
				//�ܼ�¼������10�����ǵ�ǰ��ʾ��ҳ��С��6��ǰ������ж�Ҫ
				for($i = 1;$i <= 10; $i++){
					$pagestring .= "<a href='{$url}&page={$i}'>{$i}</a>";
				}
			}

			//�ж��Ƿ������һҳ
			if($page != $pages) $pagestring .= "<a href='{$url}&page={$next}'>��һҳ</a>";

			//�����ַ���
			return $pagestring;

		}
	}