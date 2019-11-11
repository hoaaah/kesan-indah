<?php

namespace app\widgets;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\base\Widget;

/**
 * menu akses is a widget to create costumized user access
 *
 * @author Heru Arief Wijaya <heru@belajararief.com>
 * play it like this
 * use app\widgets\MenuAkses;
 * echo MenuAkses::widget(['items' => [['name' => 'Menu Name', 'id' => 100,]]])
 * advanced use see below example
 */

/*
an example of extended use of MenuAkses Widget
in this example we use triple menu like this
-- Main Menu
|---- Sub Menu 1
|----|----Sub 1 Sub Menu 1
|----|----Sub 2 Sub Menu 1
|---- Sub Menu 2

echo MenuAkses::widget([
    'headerMenu' => ['Main Menu', 'Sub Menu', 'Sub Sub Menu', 'Akses'],
    'userGroup' => $this->userGroup,
    'items' =>[
        ['name' => 'Main Menu', 'items' =>[
            ['name' => 'Sub Menu 1', 'items' => [
                ['name'=> 'Sub 1 Sub Menu 1', 'id' => 101],
                ['name' => 'Sub 2 Sub Menu 1', 'id' => 102]
            ]],
            ['name' => 'Sub Menu 2', 'id' => 201]
        ]]
    ]
])
*/
class MenuAkses extends Widget
{
    /**
     * headerMenu is an array
     * it contain header for first column (main menu), second (sub Menu). and third (sub sub menu)
     * it end with akses
     */
    public $headerMenu;
    public $items;
    public $userGroup;
    public $tableId = 'myTable';

    public function init() {
        parent::init();
        if($this->headerMenu === null)
        {
            $this->headerMenu = [
                'Main Menu', 'Sub Menu', 'Sub Sub Menu', 'Akses'
            ];
        }
    }

    public function akses($id, $menu){
        $akses = \app\models\RefUserMenu::find()->where(['kd_user' => $id, 'menu' => $menu])->one();
        IF($akses) return true;
    }    

    /**
     * Renders the menu.
     */
    public function run()
    {
        return $this->content();
    }

    public function content()
    {
        $render = $this->tableBegin($this->headerMenu);

        foreach ($this->items as $items) {
            $render .= $this->generateMainMenu($items);
        }

        $render .= $this->tableEnd();
        
        return $render;
    }

    public function generateMainMenu($items)
    {
        $return = '';
        $mainMenuName = $items['name'];
        $subMenuItems = $items['items'];
        $subMenuCount = count($subMenuItems);
        if(!isset($items['items'])){
            $return .= '
                <tr>
                    <td>'.$mainMenuName.'</td>
                    <td>-</td>
                    <td>-</td>
                    <td>
                    '.$this->generateActionButton($items['id']).'
                    </td>
                </tr>	            
            ';
            return $return;
        }
        if($subMenuCount === 1 && !isset($subMenuItems))
        {
            $return .= '
                <tr>
                    <td>'.$mainMenuName.'</td>
                    <td>'.$subMenuItems[0]['name'].'</td>
                    <td>-</td>
                    <td>
                    '.$this->generateActionButton($subMenuItems[0]['id']).'
                    </td>
                </tr>	            
            ';
            return $return;
        }

        foreach($subMenuItems as $subMenuItem)
        {
            $return .= $this->generateSubMenu($subMenuItem, $mainMenuName);
        }

        return $return;
    }

    public function generateActionButton($menuId)
    {
        IF($this->akses($this->userGroup, $menuId) === true){
            return Html::a('<i class="fas fa-check text-success"></i>', ['give', 'id' => $this->userGroup, 'menu' => $menuId, 'akses' => 0 ],
            [
                'id' => 'access-'.$menuId,
            ]);							
        }
        return Html::a('<i class="fas fa-lock text-danger"></i>', ['give', 'id' => $this->userGroup, 'menu' => $menuId, 'akses' => 1 ],
        [  
            'id' => 'access-'.$menuId,
        ]);
    }

    public function generateSubMenu($items, $mainMenuName)
    {
        $return = '';
        $subMenuName = $items['name'];
        $subSubMenuItems = $items['items'] ?? null;
        $subSubMenuCount = $subSubMenuItems ? count($subSubMenuItems) : 0;
        if(!isset($items['items'])){
            $return .= '
                <tr>
                    <td>'.$mainMenuName.'</td>
                    <td>'.$subMenuName.'</td>
                    <td>-</td>
                    <td>
                    '.$this->generateActionButton($items['id']).'
                    </td>
                </tr>	            
            ';
            return $return;
        }

        foreach($subSubMenuItems as $subSubMenuItem)
        {
            $return .= $this->generateSubSubMenu($subSubMenuItem, $mainMenuName, $subMenuName);
        }

        return $return;
    }

    public function generateSubSubMenu($items, $mainMenuName, $subMenuName)
    {

        $return = '';
        $subSubMenuName = $items['name'];
        $return .= '
            <tr>
                <td>'.$mainMenuName.'</td>
                <td>'.$subMenuName.'</td>
                <td>'.$subSubMenuName.'</td>
                <td>
                '.$this->generateActionButton($items['id']).'
                </td>
            </tr>	            
        ';
        return $return;
    }

    public function tableBegin($headerMenu)
    {
        return <<<html
            <table id="$this->tableId" class="table table-hover">
                <tbody>
                    <tr>
                        <th>$headerMenu[0]</th>
                        <th>$headerMenu[1]</th>
                        <th>$headerMenu[2]</th>
                        <th>$headerMenu[3]</th>
                    </tr>
html;

    }


    public function tableEnd()
    {
        return '
                </tbody>
            </table>    
        ';

    }    
}
