<<<<<<< HEAD
author:chen-sikora

email:Chen-Zhitong@outlook.com

PHP版本最低要求:PHP7.1.0

******2017年01月22日更新*****
1.HelperFactory中添加getFinder(mapperFactory),用于按对应type返回mapper
2.DomainObject中添加finder()方法,调用HelperFactory::getFinder返回对应的mapper
3.ObjcetWatcher中添加工作单元(Unit of Work)实现,DomainObject配合修改
******
=======================    总工作区架构     =====================

/current    :当前工作区域

/current/database    :数据库初始化文件
/current/html        :html设计文件
/current/public      :网站整体设计文件

=======================    /current/public     =====================

/composer.json      :composer配置文件
/data               :网站的缓存文件夹   （应放在文件夹外）
/html_src           :前端的资源文件夹
/index.php          :网站唯一入口
/phpunit.xml        :网站测试配置文件
/src                :网站的后端资源文件夹
/tests              :网站的测试文件
/vendor             :composer资源文件夹

=======================    /current/public/src  =====================

/database                 ：数据层文件夹
/database/collection      ：数据采集器文件夹
-------/database/mapper          :数据管理器文件夹(已弃用,将其分解成为下面几个对象)
/database/domainobjectfactory :领域工厂模式文件夹(从之前的mapper类之中分离出来)
/database/identityobject  :标识对象文件夹
/database/deletefactory   :删除工厂文件夹
/database/updatefactory   :更新/插入工厂文件夹
/database/selectionfactory:选择工厂文件夹
/database/PersistenceFactory.php :固定工厂,用于将所有的数据类结合起来,提供了统一入口
/database/DomainObjectAssembler.php :领域对象组装器,用于缓存和处理数据库连接,执行数据库操作等



/logic                    :逻辑层文件夹
/logic/base               :逻辑层注册表文件夹
/logic/command            :逻辑层命令行文件夹
/logic/controller         :逻辑层控制器文件夹
/logic/domain             :逻辑层领域对象文件夹

/view                     ：视图层文件夹


———————————————————————————————————————————————————————
用户使用流程
———————————————————————————————————————————————————————


============================1==========================
/index.php     用户唯一入口，但文件仅运行 \root\logic\controller\Controller::run();


============================2==========================

/src/logic/controller/Controller.php
初始化ApplicationHelper，之后再调用handleRequest()方法处理请求。

Controller -> handleRequest():实例化\root\logic\controller\Request()来获取请求，
再调用\root\logic\base\ApplicationRegistry::appController()获取一个AppController对象，
再用该对象的$cmd = getCommand($request)，
将刚刚获取的请求作为参数传递，再重复执行刚获得的$cmd -> excute($request),直到获取到forward转向直到最后的目标页面，
等command处理完毕,
调用ObjectWatcher::instance()->performOperations()执行工作单元的操作,
调用$this->invokeView($app_c -> getView($request))来获取视图
最后$this->invokeView：用于转向到目标页面


============================3==========================

/src/logic/controller/ApplicationHelper.php 这个类的作用解析缓存XML文件，并缓存ControllerMap类，用于映射命令之间的关系

/src/logic/controller/Request.php   这个类作用为储存和获取网页传递来的内容，调用RequestRegistry将Request储存起来

/src/logic/base/RequestRegistry.php  将Request储存起来,可以实现在再command中将Rquest保持,然后再view中调用


/src/logic/base/ApplicationRegistry.php  在Controller中调用 appController();


/src/logic/base/ApplicationRegistry.php ->appController()返回 \root\logic\controller\AppController($appMap);  再用这个调用 getCommand($request);

/src/logic/controller/AppController.php   根据ControllerMap调用Command，并转向或分发视图
getResource()根据Command的状态（Command的状态是上一个Command的状态）来转向或分发视图
getCommand()负责返回转向中需要使用的所有命令;


———————————————————————————————————————————————————————
Command类
———————————————————————————————————————————————————————

创建Command子类，仅仅实现doExecute，然后返回一个状态,即可根据XML的信息来进行转向或者分发视图。

———————————————————————————————————————————————————————
DomainObject类
———————————————————————————————————————————————————————

领域模型类，用于以对象的形式映射数据库中的表
每个对象有对应表中的字段，对应字段有get/set

对象的字段有三种情况：（以Client类为例）
1.标准的字段形式：

        $this->nickName = $nickName;
        $this->type=$type;
        $this->image=$image;
        $this->phone=$phone;

2.持有其他对象，但其他对象为单个对象:

*        $address_mapper = new \root\database\mapper\ClientAddressMapper();
*        $this -> address = $address_mapper -> find($chooseAddress);

*        $details_mapper = new \root\database\mapper\DetailsMapper();
*        $this -> details = $details_mapper -> findByClient($id);

*        $money_mapper = new \root\database\mapper\ClientMoneyMapper();
*        $this -> money = $money_mapper -> findByClient($id);

3.以其他对象集合器的形式（这个对象持有多个其他对象）:

        $this -> addresses = self::getCollection("ClientAddress");
        $this -> familys = self::getCollection("ClientFamily");
此时的集合器中是空的

4.finder()函数:返回对象对应的mapper对象
    $obj->finder()->insert($obj);

5.查找一个对象方法,例:

$factory = new \root\database\PersistenceFactory('News');
$idobj = $factory -> getIdentityObj() -> field('id') -> eq(15);
$finder = $factory -> getFinder();
$finder->find($idobj)


self::getCollection在虚基类中定义
配合HelperFactory来获取对应的collection（采集器）

如果是第三种情况，应先从对应mapper类中获取collection再设置到domain中再使用，例：
$addressesmapper = new \root\database\mapper\ClientAddressMapper();
$clientaddresscollection = $addresses_mapper -> findByclient($client->getId());
$client -> setCollection($clientaddresscollection);
然后才可以使用该collection

———————————————————————————————————————————————————————
ObjectWatcher类(标识映射类)
———————————————————————————————————————————————————————

1.作用在于将对象按照引用传递，而不是每个都实例化一个新的对象
2.工作单元(Unit of Work):
function:
    addDelete()
    addDirty()
    addNew()
    addClean()
    performOperations()    // 运行标识操作
    (调用方法: \root\logic\domain\ObjectWatcher::instance() -> performOperations();)
    (系统中在Conteroller::handleRequest(),调用)
———————————————————————————————————————————————————————
PersistenceFactory(固定工厂)
———————————————————————————————————————————————————————
1.用于将其他database相关类组合生成

查询方法:
$factory = new \root\database\PersistenceFactory('News');
$idobj = $factory -> getIdentityObj() -> field('id') -> eq(15);
$finder = $factory -> getFinder();
$finder->find($idobj);      //return collection

插入方法:
$news = new \root\logic\domain\News(null,'title','name','text','image','notice');

更新方法:
$
———————————————————————————————————————————————————————
DomainObjectAssembler类(领域对象组装器)
———————————————————————————————————————————————————————
1.用于缓存和处理数据库连接,执行数据库操作等

———————————————————————————————————————————————————————
DomainObjectFactory类(领域对象生成工厂)
———————————————————————————————————————————————————————
1.需要为每一个领域类提供一个特定实现

———————————————————————————————————————————————————————
IdentityObject类(标识对象)
———————————————————————————————————————————————————————
1.辅助类Field(接受保存字段名,通过addTest()创建operator和value的元素数组)
2.IdentityObject类作用在于组装并存储Sql语句

———————————————————————————————————————————————————————
UpdateFactory类和SelectionFactory类和DeleteFactory类
———————————————————————————————————————————————————————
1.可以更加动态地生成查询语句
2.UpdateFactory输入为DomainObject
3.SelectionFactory输入为IdentityObject
4.两个类的输出都为array($stmt,$values)
(输出为组装好的Sql语句和值)

———————————————————————————————————————————————————————
Collection类(数据集合器)
———————————————————————————————————————————————————————

1.collection类实现了Iterator接口，所以它是一个迭代器类
2.它的构造函数参数类(array,Mapper)，根据PDO查询结果的array，再根据Mapper来生成对应的领域对象，并使之可迭代
3.有一个add（），方法可以向其中追加领域对象
4.在基类各操作调用notifyAccess()，实现延迟加载
5.需要为每一个领域类提供一个特定实现
7.调用DomainObjectFactory生成对象

Collection的派生类   DeferredCollection (延迟加载类)
构造函数为（Mapper，PDOStatement，PDOValurArray）。
延迟加载类使用时机:
例如:
在ClientFamilyMapper中的方法findByClinent():

    function findByClient($id)
    {
        //返回ClientAddress的集合类
        return new \root\database\collection\DeferredClientFamilyCollection(
            $this,$this->selectByClientStmt,array($id)
        );
    }


此时返回的仅仅是一个空的collection,只有在使用这个collection的时候才会运行;


下面为延迟类的实现


class DeferredClientAddressCollection extends \root\database\collection\ClientAddressCollection //implements \root\logic\domain\NewsCollection
{
    //延迟加载类，用于在Mapper子类中延迟加载其联合的子类
    private $stmt;
    private $valueArray;
    private $run=false;

    function __construct(\root\database\mapper\Mapper $mapper,\PDOStatement $stmt_handle,array $valueArray)
    {
        parent::__construct(null,$mapper);
        $this->stmt = $stmt_handle;
        $this->valueArray = $valueArray;
    }

    function notifyAccess()
    {
        if(!$this->run){
            $this->stmt->execute($this->valueArray);
            $this->raw = $this->stmt->fetchAll();
            $this->total = count($this->raw);
        }
        $this->run = true;
    }
}


———————————————————————————————————————————————————————
localhost/?cmd=addClient
