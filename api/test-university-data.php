<?php

include_once "manage_university_company.php";
include_once "manage_university_company_jobs.php";
include_once "manage_university_recruitments.php";

/*
$universityid = 10001;

$overview = null;
$benefit = null;
$process = null;
$email = null;
$web = null;
$address = null;

$company = "山东电工电气集团有限公司";
$overview = "山东电工电气集团有限公司是国家电网公司的直属产业单位。所属山东电力设备有限公司、北京国网富达科技发展有限公司、浙江盛达铁塔有限公司、安徽宏源铁塔有限公司（安徽宏源线路器材有限公司）、江苏华电铁塔制造有限公司、重庆顺泰铁塔制造有限公司及江苏振光电力设备制造有限公司等16家全资、控股、合资公司。\n公司作为国家电网公司电磁耦合类和线路材料类业务的专业化运营平台，重点发展超/特高压变压器及电抗器业务，立足产业升级开展铁塔、线缆等业务的规模化经营。核心业务主要包括电磁耦合、电线电缆和杆塔三个业务板块，主要服务于国内特高压及智能电网建设。\n公司紧紧围绕坚强智能电网建设战略部署，加快特高压产品研发步伐，取得了一系列的科技创新成果，产品广泛应用于我国重点电力工程，覆盖全国三十个省、市、自治区，先后为晋东南-南阳1000千伏交流输电示范项目、向家坝-上海±800千伏直流输电项目、皖电东送1000千伏交流输电项目、哈密南-郑州±800千伏直流输电项目、溪洛渡-浙西±800千伏直流输电项目、浙北-福州1000千伏交流输变电项目等特高压工程提供了输变电设备和材料。";
$process = "发布招聘公告---校园宣讲会---网上投递简历---筛选简历---组织笔试和面试---确定录用人选---签订就业协议书。";
$phone = "0531-85859063,0531-67790096";
$address = "济南市市中区英雄山路101号";

manage_university_company(2, null, $company, $overview, $benefit, $process, $phone, $email, $web, $address);

$major = null;
$edu = null;
$place = null;
$salary = null;
$total = null;
$content = null;

$job = "山东电力设备有限公司";
$major = "财务管理/会计学、电力系统及其自动化、电机与电器、高电压绝缘技术及相关专业、控制科学与工程、电气工程及其自动化、机械工程/机械设计制造及自动化";
$edu = "硕士/大学本科";
$place = "山东济南";

manage_university_company_jobs(2, 1, null, $job, $major, $edu, $place, $salary, $total, $content);

$major = null;
$edu = null;
$place = null;
$salary = null;
$total = null;
$content = null;

$job = "山东电工电气集团智能电气有限公司";
$major = "电气工程及其自动化、机械设计制造及自动化";
$edu = "大学本科";
$place = "山东济南";

manage_university_company_jobs(2, 1, null, $job, $major, $edu, $place, $salary, $total, $content);

$major = null;
$edu = null;
$place = null;
$salary = null;
$total = null;
$content = null;

$job = "北京国网富达科技发展有限责任公司";
$major = "电力系统及其自动化、高电压与绝缘技术、自动化、机械电子工程、结构力学、工商管理";
$edu = "硕士及以上";
$place = "北京";

manage_university_company_jobs(2, 1, null, $job, $major, $edu, $place, $salary, $total, $content);

$major = null;
$edu = null;
$place = null;
$salary = null;
$total = null;
$content = null;

$job = "重庆顺泰铁塔制造有限公司";
$major = "财务管理/会计学、机械设计制造及自动化、材料成型及控制工程、焊接技术及自动化";
$edu = "大学本科";
$place = "重庆";

manage_university_company_jobs(2, 1, null, $job, $major, $edu, $place, $salary, $total, $content);

$major = null;
$edu = null;
$place = null;
$salary = null;
$total = null;
$content = null;

$job = "浙江盛达铁塔有限公司";
$major = "财务管理/会计学、国际经济与贸易、机械设计制造及自动化、焊接技术与工程、人力资源管理";
$edu = "大学本科";
$place = "浙江杭州";

manage_university_company_jobs(2, 1, null, $job, $major, $edu, $place, $salary, $total, $content);

$major = null;
$edu = null;
$place = null;
$salary = null;
$total = null;
$content = null;

$job = "安徽宏源铁塔有限公司（安徽宏源线路器材有限公司）";
$major = "机械设计制造及其自动化、土木工程";
$edu = "大学本科";
$place = "安徽合肥";

manage_university_company_jobs(2, 1, null, $job, $major, $edu, $place, $salary, $total, $content);

$major = null;
$edu = null;
$place = null;
$salary = null;
$total = null;
$content = null;

$job = "江苏华电铁塔制造有限公司";
$major = "财务管理/会计学、机械设计制造及自动化";
$edu = "大学本科";
$place = "江苏徐州";

manage_university_company_jobs(2, 1, null, $job, $major, $edu, $place, $salary, $total, $content);

$major = null;
$edu = null;
$place = null;
$salary = null;
$total = null;
$content = null;

$job = "江苏振光电力设备制造有限公司";
$major = "机械设计制造及自动化";
$edu = "大学本科";
$place = "江苏镇江";

manage_university_company_jobs(2, 1, null, $job, $major, $edu, $place, $salary, $total, $content);

$date = new DateTime("2014-11-17 09:00:00");
$place = "复临舍101报告厅";

manage_university_recruitments(2, $universityid, 1, $date, $place);

$overview = null;
$benefit = null;
$process = null;
$email = null;
$web = null;
$address = null;

$company = "江西省福斯特新能源集团有限公司";
$overview ="江西省福斯特新能源有限公司成立于2009年，坐落于“亚洲锂电之都”江西宜春经济开发区锂电产业园。公司占地面积700余亩，规划投资20多亿，将逐步建成年产值超100亿元集研发、生产、销售于一体的国家级高新科技企业，员工人数2500人以上。公司实际控制人蔡道国创业于1994年，2005年进军锂电行业，曾在北京、广东、湖南、云南、天津等地设有生产基地和办事机构。公司是国内领先并具有国际竞争力的锂电池电芯制造商，在亚太地区乃至国际市场具有广泛的影响力，公司产品广泛应用于手机电池、动力电池、笔记本电脑电池、数码产品电池、移动电源等领域。公司18650圆柱锂离子电池产销量居中国第一、全球第三！\n公司秉承“创新能源、造福人类”的使命，坚持“科技创新、实业报国”的经营理念，奉行“勤奋敬业，追求完美”的企业文化。\n目前公司处于高速发展阶段，公开向各类院校大学招聘应届大学毕业生，主要专业包括机械制造专业、机电专业或机电一体化专业、材料物理专业、应用化学专业等专业，公司可以为员工创造稳定的收入和舒适的工作环境。热忱欢迎各界有志之士的加盟，共创美好明天！";
$web = "www.firstbattery.com";
$address = "江西省宜春市经济技术开发区经发大道39号";

manage_university_company(2, null, $company, $overview, $benefit, $process, $phone, $email, $web, $address);

$major = null;
$edu = null;
$place = null;
$salary = null;
$total = null;
$content = null;

$job = "材料开发工程师";
$edu = "硕士及以上";
$major = "化学、材料科学与工程、材料成型及控制工程";
$total = 2;
$content = "电芯材料的研究与开发";

manage_university_company_jobs(2, 2, null, $job, $major, $edu, $place, $salary, $total, $content);

$major = null;
$edu = null;
$place = null;
$salary = null;
$total = null;
$content = null;

$job = "机理研究工程师";
$edu = "硕士及以上";
$major = "数学与应用数学、应用化学、材料科学与工程、材料成型及控制工程、机械设计制造及其自动化";
$total = 2;
$content = "电芯材料、结构、可靠性等方面机理分析";

manage_university_company_jobs(2, 2, null, $job, $major, $edu, $place, $salary, $total, $content);

$major = null;
$edu = null;
$place = null;
$salary = null;
$total = null;
$content = null;

$job = "项目工程师";
$edu = "本科及以上";
$major = "化学、应用化学、材料科学与工程、材料成型及控制工程、化学工程与工艺、机械设计制造及其自动化";
$total = 1;
$content = "电芯产品项目的管理";

manage_university_company_jobs(2, 2, null, $job, $major, $edu, $place, $salary, $total, $content);

$major = null;
$edu = null;
$place = null;
$salary = null;
$total = null;
$content = null;

$job = "管理培训生";
$edu = "本科";
$major = "应用物理学、化学、应用化学、材料科学与工程、材料成型及控制工程、电子科学与技术、化学工程与工艺、机械设计制造及其自动化";
$total = 300;
$content = "公司储备型人才";

manage_university_company_jobs(2, 2, null, $job, $major, $edu, $place, $salary, $total, $content);

$major = null;
$edu = null;
$place = null;
$salary = null;
$total = null;
$content = null;

$job = "电芯测试工程师";
$edu = "硕士及以上";
$major = "化学、材料科学与工程、机械设计制造及其自动化";
$total = 2;
$content = "电芯、材料相关的性能测试";

manage_university_company_jobs(2, 2, null, $job, $major, $edu, $place, $salary, $total, $content);

$major = null;
$edu = null;
$place = null;
$salary = null;
$total = null;
$content = null;

$job = "电芯平台开发工程师";
$edu = "硕士及以上";
$major = "应用物理学、化学、应用化学、材料科学与工程、材料成型及控制工程、化学工程与工艺";
$total = 3;
$content = "消费类电子产品、电动汽车、储能产品电芯电芯平台的设计和开发";

manage_university_company_jobs(2, 2, null, $job, $major, $edu, $place, $salary, $total, $content);

$date = new DateTime("2014-11-17 09:00:00");
$place = "复临舍201报告厅";

manage_university_recruitments(2, $universityid, 2, $date, $place);

$date = new DateTime("2014-11-18 09:00:00");
$place = "复临舍101报告厅";
manage_university_recruitments(2, $universityid, 1, $date, $place);
$date = new DateTime("2014-11-18 09:00:00");
$place = "复临舍201报告厅";
manage_university_recruitments(2, $universityid, 2, $date, $place);

$date = new DateTime("2014-11-19 09:00:00");
$place = "复临舍101报告厅";
manage_university_recruitments(2, $universityid, 1, $date, $place);
$date = new DateTime("2014-11-19 09:00:00");
$place = "复临舍201报告厅";
manage_university_recruitments(2, $universityid, 2, $date, $place);

$date = new DateTime("2014-11-20 09:00:00");
$place = "复临舍101报告厅";
manage_university_recruitments(2, $universityid, 1, $date, $place);
$date = new DateTime("2014-11-20 09:00:00");
$place = "复临舍201报告厅";
manage_university_recruitments(2, $universityid, 2, $date, $place);

$date = new DateTime("2014-11-21 09:00:00");
$place = "复临舍101报告厅";
manage_university_recruitments(2, $universityid, 1, $date, $place);
$date = new DateTime("2014-11-21 09:00:00");
$place = "复临舍201报告厅";
manage_university_recruitments(2, $universityid, 2, $date, $place);

$date = new DateTime("2014-11-22 09:00:00");
$place = "复临舍101报告厅";
manage_university_recruitments(2, $universityid, 1, $date, $place);
$date = new DateTime("2014-11-23 09:00:00");
$place = "复临舍201报告厅";
manage_university_recruitments(2, $universityid, 2, $date, $place);

$date = new DateTime("2014-11-24 09:00:00");
$place = "复临舍101报告厅";
manage_university_recruitments(2, $universityid, 1, $date, $place);
$date = new DateTime("2014-11-25 09:00:00");
$place = "复临舍201报告厅";
manage_university_recruitments(2, $universityid, 2, $date, $place);

$date = new DateTime("2014-11-26 09:00:00");
$place = "复临舍101报告厅";
manage_university_recruitments(2, $universityid, 1, $date, $place);
$date = new DateTime("2014-11-27 09:00:00");
$place = "复临舍201报告厅";
manage_university_recruitments(2, $universityid, 2, $date, $place);

$date = new DateTime("2014-11-28 09:00:00");
$place = "复临舍101报告厅";
manage_university_recruitments(2, $universityid, 1, $date, $place);
$date = new DateTime("2014-11-29 09:00:00");
$place = "复临舍201报告厅";
manage_university_recruitments(2, $universityid, 2, $date, $place);

$date = new DateTime("2014-11-30 09:00:00");
$place = "复临舍101报告厅";
manage_university_recruitments(2, $universityid, 1, $date, $place);
$date = new DateTime("2014-11-30 09:00:00");
$place = "复临舍201报告厅";
manage_university_recruitments(2, $universityid, 2, $date, $place);

$date = new DateTime("2014-12-01 09:00:00");
$place = "复临舍101报告厅";
manage_university_recruitments(2, $universityid, 1, $date, $place);
$date = new DateTime("2014-12-02 10:00:00");
$place = "复临舍201报告厅";
manage_university_recruitments(2, $universityid, 2, $date, $place);

$date = new DateTime("2014-12-03 09:00:00");
$place = "复临舍101报告厅";
manage_university_recruitments(2, $universityid, 1, $date, $place);
$date = new DateTime("2014-12-04 10:00:00");
$place = "复临舍201报告厅";
manage_university_recruitments(2, $universityid, 2, $date, $place);

$date = new DateTime("2014-12-05 09:00:00");
$place = "复临舍101报告厅";
manage_university_recruitments(2, $universityid, 1, $date, $place);
$date = new DateTime("2014-12-06 10:00:00");
$place = "复临舍201报告厅";
manage_university_recruitments(2, $universityid, 2, $date, $place);

$date = new DateTime("2014-12-07 09:00:00");
$place = "复临舍101报告厅";
manage_university_recruitments(2, $universityid, 1, $date, $place);
$date = new DateTime("2014-12-08 10:00:00");
$place = "复临舍201报告厅";
manage_university_recruitments(2, $universityid, 2, $date, $place);
*/

// -- --------------------------------------------

$company = "深圳市金融联客户服务中心股份有限公司";
$overview = "深圳市金融联客户服务中心股份有限公司（以下简称“金融联客服中心”）成立于2002年11月，注册资本1000万元，属深圳联合金融服务集团有限公司 （深圳金融电子结算中心控股的国有企业）全资控股子公司。公司总部位于中国深圳，目前分别在北京、东莞、南昌等地设立了4家分支机构，拥有员工数量1500多人，拥有国家工业和信息化部颁发的电信增值业务经营许可证，主要从事呼叫中心（CALL CENTER）业务，是国内最早一批将呼叫中心应用于金融、电信、公共事业等行业的大型呼叫中心企业之一，也是国内首家建立银行客户增值服务的金融配套服务运营商，同时也是国内固话套餐业务最早的设计者和市场参与者。公司坚持以人为本，员工与企业共成长的管理理念。现因公司高速发展的需要，我们诚邀广大精英的加盟，我们将会为您提供广阔的职业发展平台、系统的培训晋升机制和有竞争力的薪酬福利！";
$benefit = "五险一金，包食宿。员工食堂、职工宿舍、带薪年假、医疗优惠、培训津贴、健康体检、公司旅游、生日礼物、拓展训练、荣誉表彰、文体竞赛、节日礼品。";
$process = "发布招聘公告---校园招聘会---投递简历---筛选简历---电话面试或学校集中面试---确定录用人选---签订就业协议书。";
$email = "1125071458@qq.com";
$phone = "18673112370";
$web = "www.cufs.cc";
$address = "深圳市龙岗区宝龙工业区南创维群欣科技园1栋4楼";

manage_university_company(2, null, $company, $overview, $benefit, $process, $phone, $email, $web, $address);

$job = "交通银行客服销售助理（银行项目）";
$major = "金融、经济管理、财务管理、会计、市场营销等专业优先，国际贸易、英语、文秘等专业优秀学生也可";
$edu = "大专以上";
$place = "上海、昆山";
$salary = "基本工资3770元/月，绩效工资500-2000";
$total = 10;
$content = "培训期2-3周，每天50元补助。试用期3个月，享有基本工资。转正后综合工资4500-6000。普通话标准；计算机录入文字速度40字/分；具有较强的的语言表达能力、分析能力、学习能力，且有正确的客户服务理念。工作时间为五天八小时或六天六小时工作制。";

manage_university_company_jobs(2, 1, null, $job, $major, $edu, $place, $salary, $total, $content);

$job = "福州邮政银行客服销售助理";
$major = "金融、经济管理、财务管理、会计、市场营销等专业优先，国际贸易、英语、文秘等专业优秀学生也可";
$edu = "大专以上";
$place = "福州、厦门";
$salary = "基本工资3500元/月，绩效工资500-2000";
$total = 5;
$content = "培训期2-3周，每天50元补助。试用期3个月，享有基本工资。转正后综合工资4300-5800。普通话标准；计算机录入文字速度40字/分；具有较强的的语言表达能力、分析能力、学习能力，且有正确的客户服务理念。工作时间为五天八小时或六天六小时工作制。";

manage_university_company_jobs(2, 1, null, $job, $major, $edu, $place, $salary, $total, $content);

$job = "兴业银行小额贷款审核与账单分期业务助理";
$major = "金融、经济管理、财务管理、会计、市场营销等专业优先，国际贸易、英语、文秘等专业优秀学生也可";
$edu = "大专以上";
$place = "上海、昆山";
$salary = "基本工资2770元/月，绩效工资500-1500";
$total = 5;
$content = "培训期1周，每天50元补助。试用期3个月，享有基本工资。转正后综合工资3500-5000。普通话标准；计算机录入文字速度40字/分；具有较强的的语言表达能力、分析能力、学习能力，且有正确的客户服务理念。工作时间为五天八小时或六天六小时工作制。";

manage_university_company_jobs(2, 1, null, $job, $major, $edu, $place, $salary, $total, $content);

$job = "民生银行客服助理";
$major = "金融、经济管理、财务管理、会计、市场营销等专业优先，国际贸易、英语、文秘等专业优秀学生也可";
$edu = "大专以上";
$place = "深圳、西安、长沙";
$salary = "基本工资2500元/月，综合工资3500-4500";
$total = 5;
$content = "培训期1周，每天50元补助。试用期3个月，享有基本工资。转正后综合工资3500-4500。普通话标准；计算机录入文字速度40字/分；具有较强的的语言表达能力、分析能力、学习能力，且有正确的客户服务理念。工作时间为五天八小时或六天六小时工作制。";

manage_university_company_jobs(2, 1, null, $job, $major, $edu, $place, $salary, $total, $content);

$job = "电信10086客服专员";
$major = "金融、经济管理、财务管理、会计、市场营销等专业优先，国际贸易、英语、文秘等专业优秀学生也可";
$edu = "大专以上";
$place = "深圳、广州";
$salary = "基本工资2500元/月，综合工资3000-4000元";
$total = 6;
$content = "培训期1周，每天50元补助。试用期3个月，享有基本工资。转正后综合工资3000-4000。普通话标准；计算机录入文字速度40字/分；具有较强的的语言表达能力、分析能力、学习能力，且有正确的客户服务理念。工作时间为五天八小时或六天六小时工作制。";

manage_university_company_jobs(2, 1, null, $job, $major, $edu, $place, $salary, $total, $content);

$universityid = 11532;
$date = new DateTime("2014-11-22 08:30:00");
$place = "体育馆负一楼";
manage_university_recruitments(2, $universityid, 1, $date, $place);


$universityid = 10543;
$date = new DateTime("2014-11-22 08:30:00");
$place = "(东院)综合训练馆";
manage_university_recruitments(2, $universityid, 1, $date, $place);

?>
