<?php
include('./components/nav.php');

if (!isset($_GET['ID'])) {
    die('no id');
}

$id = (int) $_GET['ID'];

$stmt = $mysqli->prepare("SELECT * FROM catalog WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$item = $result->fetch_assoc();

$stmt = $mysqli->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $item['creator_id']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>
				<div id="Body">
					
	<div id="ItemContainer">
		<div id="Item">
		    <h2>ROBLOX Hat</h2>
		    <div id="Details">
		        <div id="ctl00_cphRoblox_AssetThumbnailPanel">
	
			        <div id="Thumbnail">
				        <a id="ctl00_cphRoblox_AssetThumbnailImage" disabled="disabled" title="Shades" onclick="return false" style="display:inline-block;"><img src="/Thumbs/Hat.ashx?ID=<?=$item['id']?>" height=250px width=250px border="0" alt="Shades" blankurl="http://t6.roblox.com:80/blank-250x250.gif"></a>
			        </div>
			    
</div>
			    
			    <div id="Summary">
				    <h3><?=$item['name']?></h3>
                    
			        <?php
                    $stmt = $mysqli->prepare("SELECT 1 FROM inventory WHERE user_id = ? AND item_id = ?");
                    $stmt->bind_param("ii", $_SESSION['userid'], $item['id']);
                    $stmt->execute();
                    $owned = $stmt->get_result()->fetch_assoc();

                    if (!$owned) {

                    if ($item['price_robux'] != 0) {
                        echo '
                        <div id="ctl00_cphRoblox_RobuxPurchasePanel">	
                            <div id="RobuxPurchase">
                                <div id="PriceInRobux">Rx: ' . $item['price_robux'] . '</div>
                                <div id="BuyWithRobux">
                                    <a id="ctl00_cphRoblox_PurchaseWithRobuxButton" class="Button" href="/api/buy.php?id=' . $item['id'] . '&t=rbx">Buy with Rx</a>
                                </div>
                            </div>
                        </div>
                        ';
                    }

                    if ($item['price_tix'] != 0) {
                        echo '
                        <div id="ctl00_cphRoblox_TicketsPurchasePanel">	
                            <div id="TicketsPurchase">
                                <div id="PriceInTickets">Tx: ' . $item['price_tix'] . '</div>
                                <div id="BuyWithTickets">
                                    <a id="ctl00_cphRoblox_PurchaseWithRobuxButton" class="Button" href="/api/buy.php?id=' . $item['id'] . '&t=tix">Buy with Tx</a>
                                </div>
                            </div>
                        </div>
                        ';
                    }

                    } else {
                        echo '<h1>Owned (temp)</h1>';
                    }
                    ?>
				    <div id="Creator">Created by: <a id="ctl00_cphRoblox_CreatorHyperLink" href="User.aspx?ID=<?=$item['creator_id']?>>"><?=$user['name']?></a></div>
				    <div id="LastUpdate">Updated: Alot</div>
				    <div id="ctl00_cphRoblox_DescriptionPanel">
	
					    <div id="DescriptionLabel">Description:</div>
					    <div id="Description"><?=$item['description']?></div>
				    
</div>
	                <div id="ReportAbuse"><div id="ctl00_cphRoblox_AbuseReportButton1_AbuseReportPanel" class="ReportAbusePanel">
	
    <span class="AbuseIcon"><a id="ctl00_cphRoblox_AbuseReportButton1_ReportAbuseIconHyperLink" href="AbuseReport/AssetVersion.aspx?ID=1223787&amp;ReturnUrl=http%3a%2f%2fwww.roblox.com%2fItem.aspx%3fID%3d1577409"><img src="/assets/abuse.PNG" alt="Report Abuse" border="0"></a></span>
    <span class="AbuseButton"><a id="ctl00_cphRoblox_AbuseReportButton1_ReportAbuseTextHyperLink" href="AbuseReport/AssetVersion.aspx?ID=1223787&amp;ReturnUrl=http%3a%2f%2fwww.roblox.com%2fItem.aspx%3fID%3d1577409">Report Abuse</a></span>

</div></div>
			    </div>
			    
			    
			    <div style="clear: both;"></div>
			</div>
			<div id="ctl00_cphRoblox_CommentsPane_CommentsUpdatePanel">
	
        <div class="CommentsContainer">
            
                    <h3>Comments (1259)</h3>
                    <div id="ctl00_cphRoblox_CommentsPane_CommentsRepeater_ctl00_HeaderPagerPanel" class="HeaderPager">
			            
			            <span id="ctl00_cphRoblox_CommentsPane_CommentsRepeater_ctl00_HeaderPagerLabel">Page 1 of 1</span>
			            <a id="ctl00_cphRoblox_CommentsPane_CommentsRepeater_ctl00_HeaderPageSelector_Next" href="javascript:__doPostBack('ctl00$cphRoblox$CommentsPane$CommentsRepeater$ctl00$HeaderPageSelector_Next','')">Next <span class="NavigationIndicators">&gt;&gt;</span></a>
		            </div>
		            <div class="Comments">
                
                    <div class="Comment">
                        <div class="Commenter">
                            <div class="Avatar">
                                <a id="ctl00_cphRoblox_CommentsPane_CommentsRepeater_ctl01_AvatarImage" title="Admin" href="/User.aspx?ID=1" style="display:inline-block;cursor:pointer;"><img src="/Thumbs/Avatar.ashx?ID=1" width=64px height=64px border="0" alt="Admin" blankurl="http://t6.roblox.com:80/blank-64x64.gif"></a></div>
                        </div>
                        <div class="Post">
                            <div class="Audit">
                                Posted
                                0 hours ago
                                by
                                <a id="ctl00_cphRoblox_CommentsPane_CommentsRepeater_ctl01_UsernameHyperLink" href="User.aspx?ID=1">Admin</a>
                            </div>
                            <div class="Content">tung tung tung sahur</div>
                        </div>
                        <div style="clear: both;"></div>
                    </div>
                
                    </div>
                    <div id="ctl00_cphRoblox_CommentsPane_CommentsRepeater_ctl11_FooterPagerPanel" class="FooterPager">
			            
			            <span id="ctl00_cphRoblox_CommentsPane_CommentsRepeater_ctl11_FooterPagerLabel">Page 1 of 1</span>
			            <a id="ctl00_cphRoblox_CommentsPane_CommentsRepeater_ctl11_FooterPageSelector_Next" href="javascript:__doPostBack('ctl00$cphRoblox$CommentsPane$CommentsRepeater$ctl11$FooterPageSelector_Next','')">Next <span class="NavigationIndicators">&gt;&gt;</span></a>
		            </div>
                
            
        </div>
    
</div>
		</div>
		
<div class="Ads_WideSkyscraper">
    <img src="/assets/AdSkyscraperTemplate.png" alt="ad" width="160" height="600" border="1">
</div>

	    <div style="clear: both;">
	</div>
	
	<div id="ctl00_cphRoblox_ItemPurchasePopupPanel" class="modalPopup" style="display: none">
	
		<div id="ctl00_cphRoblox_ItemPurchasePopupUpdatePanel">
		
				
			
	</div>
	
</div>
	
	<input type="hidden" name="ctl00$cphRoblox$HiddenField1" id="ctl00_cphRoblox_HiddenField1">
	<input type="hidden" name="ctl00$cphRoblox$HiddenField2" id="ctl00_cphRoblox_HiddenField2">
	<input type="hidden" name="ctl00$cphRoblox$HiddenField3" id="ctl00_cphRoblox_HiddenField3">
	

				</div>
<?php
include('./components/footer.php');
?>