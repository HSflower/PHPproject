<?include $_SERVER["DOCUMENT_ROOT"] . "/classes/DB.php";
if(!class_exists("Users")){

	class Users extends DB{
//	class Users{
		/*
		function Users() 
		{
			$this->HomeFrm($req,$xmlKey) ;	
		}
		*/
		/***************************************************************************
		*	제  목 : 견적 등록
		*	함수명 : insQuota
		*	작성일 : 2015-04-13
		*	작성자 : 김한슬
		*	설  명 : www/submitProc.php가 대신 처리함.
		*	수  정 :
		'***************************************************************************/
		function insQuota()
		{
			$userNumber			= $this->req["userNumber"];
			$quotaNumber		= $this->req["quotaNumber"];
			$companyName		= $this->req["companyName"];
			$registDT			= $this->req["registDT"];
			$closedDT			= $this->req["closedDT"];
			$category			= $this->req["category"];
			$adminDistrict		= $this->req["adminDistrict"];
			$quotaNote			= $this->req["quotaNote"];
			//quotaNumber는 auot_increment인데 왜 request하지?

			if($quotaNumber != "")
			{
				$sql = "
					UPDATE tblQuota
					SET companyName			= '{$companyName}',
						registDT			= '{$registDT}',
						closedDT			= '{$closedDT}',
						category			= '{$category}',
						adminDistrict		= '{$adminDistrict}',
						quotaNote			= '{$quotaNote}',
					WHERE quotaNumber = '{$quotaNumber}'
				";
			}
			else
			{
				$sql = "
					INSERT INTO tblQuota (companyName, registDT, closedDT, category, adminDistrict, quotaNote)
					VALUES ('{$companyName}', '{$registDT}', '{$closedDT}', '{$category}', '{$adminDistrict}')
				";
			}

			$this->update($sql);
		}

		/***************************************************************************
		*	제  목 : 업체 등록
		*	함수명 : insCompany
		*	작성일 : 2015-04-13
		*	작성자 : 김한슬
		*	설  명 : www/insCmpProc.php가 대신 처리함.
		*	수  정 :
		'***************************************************************************/
		function insCompany()
		{
			$quotaNumber		= $this->req["quotaNumber"];
			$companyNumber		= $this->req["companyNumber"];
			$userNumber			= $this->req["userNumber"];
			$email				= $this->req["email"];
			$address			= $this->req["address"];
			$companyID			= $this->req["companyID"];
			$companyPW			= $this->req["companyPW"];
			$companyName		= $this->req["companyName"];
			$ceoName			= $this->req["ceoName"];
			$ceoPhone			= $this->req["ceoPhone"];
			$storePhone			= $this->req["storePhone"];
			$adminDistrict		= $this->req["adminDistrict"];
			$openDT				= $this->req["openDT"];
			$deliveryTime		= $this->req["deliveryTime"];
			$companyNote		= $this->req["companyNote"];

			
			if($companyNumber != "")
			{
				$sql = "
					UPDATE tblCompany
					SET quotaNumber			= '{$quotaNumber}',
						userNumber			= '{$userNumber}',
						email				= '{$email}',
						address				= '{$address}',
						companyID			= '{$companyID}',
						companyPW			= '{$companyPW}',
						companyName			= '{$companyName}',
						ceoName				= '{$ceoName}',
						ceoPhone			= '{$ceoPhone}',
						storePhone			= '{$storePhone}',
						adminDistrict		= '{$adminDistrict}',
						openDT				= '{$openDT}',
						deliveryTime		= '{$deliveryTime}',
						companyNote			= '{$companyNote}'
					WHERE companyNumber = '{$companyNumber}'
				";
			}
			else
			{
				$sql = "
					INSERT INTO tblCompany (quotaNumber, userNumber, email, address, companyName,
										 ceoName, ceoPhone, companyID, companyPW, adminDistrict, storePhone,
										 adminDistrict, openDT, deliveryTime, companyNote)
					VALUES ('{$quotaNumber}', '{$userNumber}', '{$email}', '{$address}', '{$companyName}', 
							'{$ceoName}', '{$ceoPhone}', '{$companyID}', '{$companyPW}','{$adminDistrict}','{$storePhone}',
							'{$adminDistrict}', '{$openDT}', '{$deliveryTime}', '{$companyNote}')
				";
			}

			$this->update($sql);
		}

		/***************************************************************************
		*	제  목 : CS 등록 
		*	함수명 : insCS
		*	작성일 : 2015-04
		*	작성자 : 김한슬
		*	설  명 : 
		*	수  정 :
		'***************************************************************************/
		function insCS()
		{
			$csNumber			= $this->req["csNumber"];
			$occurDT			= $this->req["occurDT"];
			$processDT			= $this->req["processDT"];
			$csLcategory		= $this->req["csLcategory"];
			$csMcategory		= $this->req["csMcategory"];
			$csScategory		= $this->req["csScategory"];
			$companyName		= $this->req["companyName"];
			$csProcess			= $this->req["csProcess"];
			$csAction			= $this->req["csAction"];
			$csReaction			= $this->req["csReaction"];
			$csNote				= $this->req["csNote"];

			if($csNumber != "")
			{
				$sql = "
					UPDATE tblCS
					SET occurDT				= '{$occurDT}',
						processDT			= '{$processDT}',
						csLcategory			= '{$csLcategory}',
						csMcategory			= '{$csMcategory}',
						csScategory			= '{$csScategory}',
						companyName			= '{$companyName}',
						csProcess			= '{$csProcess}',
						csAction			= '{$csAction}',
						csReaction			= '{$csReaction}',
						csNote				= '{$csNote}'
					WHERE csNumber			= '{$csNumber}'
				";
			}
			else
			{
				$sql = "
					INSERT INTO tblCS (occurDT, processDT, csLcategory, csMcategory, csScategory, companyName,
										 csProcess, csAction, csReaction, csNote)
					VALUES ('{$occurDT}', '{$processDT}', '{$csLcategory}', '{$csMcategory}', '{$csScategory}', '{$companyName}',
							'{$csProcess}', '{$csAction}', '{$csReaction}', '{$csNote}', '{$csNumber}')
				";
			}

			$this->update($sql);
		}

		/***************************************************************************
		*	제  목 : 배송 등록 /영업일지
		*	함수명 : insDelivery
		*	작성일 : 2015-04
		*	작성자 : 김한슬
		*	설  명 : 
		*	수  정 :
		'***************************************************************************/

		/***************************************************************************
		*	제  목 : 영업일지 등록
		*	함수명 : insSalesDiary
		*	작성일 : 2015-04
		*	작성자 : 김한슬
		*	설  명 : 
		*	수  정 :
		'***************************************************************************/
		function insSalesDiary()
		{
			$diaryNumber		= $this->req["diaryNumber"];
			$companyName		= $this->req["companyName"];
			$salesDT			= $this->req["salesDT"];
			$staffName			= $this->req["staffName"];
			$staffPosition		= $this->req["staffPosition"];
			$staffPhone			= $this->req["staffPhone"];
			$salesProcess		= $this->req["salesProcess"];
			$processNum			= $this->req["processNum"];
			$possibility		= $this->req["possibility"];
			$salesNote			= $this->req["salesNote"];
			
			if($companyNumber != "")
			{
				$sql = "
					UPDATE tblSalesDiary
					SET companyName			= '{$companyName}',
						salesDT				= '{$salesDT}',
						staffName			= '{$staffName}',
						staffPosition		= '{$staffPosition}',
						staffPhone			= '{$staffPhone}',
						salesProcess		= '{$salesProcess}',
						processNum			= '{$processNum}',
						possibility			= '{$possibility}',
						salesNote			= '{$salesNote}'
					WHERE diaryNumber = '{$diaryNumber}'
				";
			}
			else
			{
				$sql = "
					INSERT INTO tblSalesDiary (companyName, salesDT, staffName, staffPosition, staffPhone, salesProcess, 
						processNum, possibility, salesNote)
					VALUES ('{$companyName}', '{$salesDT}', '{$staffName}', '{$staffPosition}', '{$staffPhone}', 
						'{$salesProcess}', '{$processNum}', '{$possibility}', '{$salesNote}')
				";
			}

			$this->update($sql);
		}

		//join 방법 알아보기 - blog
		/***************************************************************************
		*	제  목 : 견적 상세 정보 가져오기
		*	함수명 : getQuotaInfo
		*	작성일 : 2015-04-14
		*	작성자 : 김한슬
		*	설  명 : 
		*	수  정 :
		'***************************************************************************/
		function getQuotaInfo()
		{
			if(isset($_POST["quotaNumber"])){
				$quotaNumber		= $this->req["quotaNumber"];
				$sql = "
				SELECT Q.userNumber, Q.cName, Q.registDT, Q.category, Q.clsDT, Q.adDstr, Q.qNote
				FROM tblQuota Q
				WHERE Q.quotaNumber = '{$quotaNumber}'
				LIMIT 1 
				";
			} else {
				$sql = "SELECT Q.userNumber, Q.cName, Q.registDT, Q.category, Q.clsDT, Q.adDstr, Q.qNote FROM tblQuota Q WHERE 1=1";
			}
			
			return $this->getRow($sql);
		}

		/***************************************************************************
		*	제  목 : 견적 리스트 가져오기
		*	함수명 : getQuotaInfo
		*	작성일 : 2015-04-14
		*	작성자 : 김한슬
		*	설  명 : 
		*	수  정 :
		'***************************************************************************/
		function getQuotaList()
		{
			$sql = "SELECT Q.userNumber, Q.cName, Q.registDT, Q.category, Q.clsDT, Q.adDstr, Q.qNote FROM tblQuota Q";

			return $this->getArray($sql);
		}

		/***************************************************************************
		*	제  목 : 업체 상세 정보 가져오기
		*	함수명 : getCompanyInfo
		*	작성일 : 2015-04-14
		*	작성자 : 김한슬
		*	설  명 : 
		*	수  정 :
		'***************************************************************************/
		function getCompanyInfo()
		{
			$companyNumber		= $this->req["companyNumber"];

			$sql = "
				SELECT C.companyName, C.ceoName, C.ceoPhone, C.storePhone, C.address, C.email, 
					C.adminDistrict, C.processState, C.openDT, C.deliveryTime, C.companyNote, C.companyID, C.companyPW
				FROM tblCompany C
				WHERE C.companyNumber = '{$companyNumber}'
				LIMIT 1
			";

			return $this->getRow($sql);
		}

		/***************************************************************************
		*	제  목 : CS  상세 정보 가져오기
		*	함수명 : getCsInfo
		*	작성일 : 2015-04-15
		*	작성자 : 김한슬
		*	설  명 : 
		*	수  정 :
		'***************************************************************************/
		function getCsInfo()
		{
			$csNumber		= $this->req["csNumber"];

			$sql = "
				SELECT Cs.occurDT, Cs.processDT, Cs.csAction, Cs.csReaction, Cs.csProcess, C.companyName
				FROM tblCs Cs
				WHERE Cs.csNumber = '{$csNumber}'
			";
			//select companyName join with tblCompany
			return $this->getRow($sql);
		}

		/***************************************************************************
		*	제  목 : 배송 상세 정보 가져오기
		*	함수명 : getDeliveryInfo
		*	작성일 : 2015-04-14
		*	작성자 : 김한슬
		*	설  명 : 
		*	수  정 :
		'***************************************************************************/
		function getDeliveryInfo()
		{
			$companyNumber		= $this->req["companyNumber"];

			$sql = "
				SELECT Cs.occurDT, Cs.processDT, Cs.csAction, Cs.csReaction, Cs.csProcess
				FROM tblCs Cs
				WHERE Cs.csNumber = '{$csNumber}'
				LIMIT 1
			";

			return $this->getRow($sql);
		}

		/***************************************************************************
		*	제  목 : 영업일지 상세 정보 가져오기
		*	함수명 : getSalesDiaryInfo
		*	작성일 : 2015-04-14
		*	작성자 : 김한슬
		*	설  명 : 
		*	수  정 :
		'***************************************************************************/
		function getSalesDiaryInfo()
		{
			$diaryNumber		= $this->req["diaryNumber"];

			$sql = "
				SELECT D.companyName, D.salesDT, D.staffName, D.staffPosition, D.staffPhone, D.salesProcess, D.processNum, D.possibility, D.salesNote
				FROM tblSalesDiary
				WHERE D.diaryNumber = '{$diaryNumber}'
				LIMIT 1
			";

			return $this->getRow($sql);
		}
	}
}