<?php
$stmt = $mysqli->prepare("SELECT item_id FROM inventory WHERE user_id = ?");
$stmt->bind_param("i", $_SESSION['userid']);
$stmt->execute();

$result = $stmt->get_result();
?>
<div id="Body">


    <title>My Character - <?= htmlspecialchars($user['username']) ?></title>
    <style>
        h4 {
            background-color: #ccc;
            border-bottom: solid 1px #000;
            color: #333;
            font-family: Comic Sans MS, Verdana, Sans-Serif;
            margin: 0;
            text-align: center;
        }
        .CharacterViewer2 {
            float: right;
            width: 354px;
        }
        .spinner {
            position: absolute;
            width: 20px;
            height: 20px;
            pointer-events: none;
        }
        .popupControl {
            position: absolute;
            background: white;
            border: 1px solid black;
            padding: 5px;
            z-index: 1000;
            visibility: hidden;
        }
        .ColorPickerItem {
            cursor: pointer;
            border: 1px solid #ccc;
        }
        
        .ColorPickerItem:hover {
            border: 2px solid #000;
        }
        .disabled {
            color: gray;
            pointer-events: none;
        }
        .bp1 { background-color: #A4BD47; }
        .bp2 { background-color: #F5CD30; }
        .bp3 { background-color: #D7C59A; }
        .bp4 { background-color: #F5CD30; }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<div id="Body">
    <div class="MyTriaxxContainer">
        <div id="ctl00_ctl00_cphTriaxx_cphMyTriaxxContent_CustomizeCharacterUpdatePanel"></div>
        
        <script>
document.addEventListener("DOMContentLoaded", function () {
    fetch("/api/changecolor.ashx?mode=get&ID=<?= (int)$user['id'] ?>")
        .then(res => res.json())
        .then(data => {
            applyColors(data);
            syncColorChooser(data);
        })
        .catch(err => {
            console.error("failed load color", err);
            
        });
});
        function togglePopup(id) {
    const el = document.getElementById(id);
    if (!el) return;

    const isHidden = el.style.visibility === "hidden" || el.style.visibility === "";

    document.querySelectorAll('.popupControl').forEach(p => {
        p.style.visibility = "hidden";
    });

    el.style.visibility = isHidden ? "visible" : "hidden";
}

document.addEventListener('click', function (e) {
    if (!e.target.closest('.popupControl') && !e.target.closest('[onclick^="togglepopup"]')) {
        document.querySelectorAll('.popupControl').forEach(p => {
            p.style.visibility = "hidden";
        });
    }
});

function getColor(id) {
    const colors = {
        1: "#F2F3F3", 5: "#D7C59A", 9: "#E8BAC8", 11: "#80BBDC",
        18: "#CC8E69", 21: "#C4281C", 23: "#0D69AC", 24: "#F5CD30",
        26: "#1B2A35", 28: "#287F47", 29: "#A1C48C", 37: "#4B974B",
        38: "#A05F35", 45: "#B4D2E4", 101: "#DA867A", 102: "#6E99CA",
        104: "#6B327C", 105: "#E29B40", 106: "#DA8541", 107: "#008F9C",
        119: "#A4BD47", 125: "#EAB892", 135: "#74869D", 141: "#27462D",
        151: "#789082", 153: "#957977", 192: "#694028", 194: "#A3A2A5",
        199: "#635F62", 208: "#E5E4DF", 217: "#7C5C46", 226: "#FDEA8D"
    };

    return colors[id] || "#FFFFFF";
}

let renderTimeout = null;

function changebcolor(partid, color) {
    document.getElementById('spinner').style.display = 'block';

    $.post("/api/changecolor.php", {
        part: partid,
        color: color,
        csrf: $("meta[name='csrf_token']").attr("content")
        
    })
    .done(function (res) {
        if (res.error) {
            alert(res.error);
            return;
        }

        applyColors(res);
        sessionStorage.setItem('returnUrl', window.location.href);
        window.location.href = '/api/render.aspx?ID=<?= (int)$user['id'] ?>';
        return false;
    })
    .fail(function (xhr) {
        console.error("post failed:", xhr.responseText);
        alert("req failed");
    })
    .always(function () {
        document.getElementById('spinner').style.display = 'none';
    });
}
function togglepopup1() { togglePopup("PopupRightLeg"); }
function togglepopup2() { togglePopup("PopupHead"); }
function togglepopup3() { togglePopup("PopupTorso"); }
function togglepopup4() { togglePopup("PopupLeftArm"); }
function togglepopup5() { togglePopup("PopupRightArm"); }
function togglepopup6() { togglePopup("PopupLeftLeg"); }

$(document).ready(function () {
    $("#avatarthumb").attr(
        "src",
        "/Thumbs/Avatar.ashx?ID=<?= (int)$user['id'] ?>"
    );
});

        </script>
        
        <div class="CharacterViewer2">
            <div style="border: black solid thin;">
                <h4>My Character</h4>
                <div class="StandardBox">
                    <div>
                        <img id="spinner" class="spinner" style="display: none;" src="/assets/ProgressIndicator2.gif">
                        <a title="<?= htmlspecialchars($_SESSION['username']) ?>" onclick="return false" style="display:inline-block;height:352px;width:352px;">
                             <img id="avatarthumb"
                              src="/Thumbs/Avatar.ashx?ID=<?= (int)$user['id'] ?>"
                                        width="352"
                                            height="352"
                                            border="0"
                         alt="<?= htmlspecialchars($_SESSION['username']) ?>"></a>
                        </a>
                        <div class="ReDrawAvatar">
                        <a href="#"
                        onclick="
                            sessionStorage.setItem('returnUrl', window.location.href);
                            window.location.href = '/api/equip.aspx?ID=0';
                            return false;
                        ">
                        Remove hat
                        </a>
                        </div>
                        <div class="ReDrawAvatar">
                            <span>Something wrong with your Avatar?</span>
                        <a href="#"
                        onclick="
                            sessionStorage.setItem('returnUrl', window.location.href);
                            window.location.href = '/api/render.aspx?ID=<?= (int)$user['id'] ?>';
                            return false;
                        ">
                        Click here to re-draw it!
                        </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <br>
            <center>
                <div style="border: black solid thin;">
                    <h4>Color Chooser</h4>
                    <div class="StandardBox">
                        <div>
                            <p>Click a body part to change its color:</p>
                            <div class="ColorChooserFrame" style="height:236px;width:176px;text-align:center;">
                                <div style="position: relative; margin: 11px 11px; height: 1%;">
                                    <div style="position: absolute; left: 120px; top: 44px; cursor: pointer">
                                        <div id="LeftArmSelector" class="bp4" style="height:72px;width:32px;" onclick="togglepopup4();"></div>
                                    </div>
                                    <div style="position: absolute; left: 40px; top: 44px; cursor: pointer">
                                        <div id="TorsoSelector" style="height:72px;width:72px;" class="bp3" onclick="togglepopup3();"></div>
                                    </div>
                                    <div style="position: absolute; left: 0px; top: 44px; cursor: pointer">
                                        <div id="RightArmSelector" style="height:72px;width:32px;" class="bp4" onclick="togglepopup5();"></div>
                                    </div>
                                    <div style="position: absolute; left: 58px; top: 0px; cursor: pointer">
                                        <div id="HeadSelector" style="height:36px;width:36px;" class="bp2" onclick="togglepopup2();"></div>
                                    </div>
                                    <div style="position: absolute; left: 40px; top: 124px; cursor: pointer">
                                        <div id="RightLegSelector" style="height:72px;width:32px;" class="bp1" onclick="togglepopup1();"></div>
                                    </div>
                                    <div style="position: absolute; left: 80px; top: 124px; cursor: pointer">
                                        <div id="LeftLegSelector" style="height:72px;width:32px;" class="bp1" onclick="togglepopup6();"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </center>
        </div>
        
        <div id="CustomizeCharacterContainer">
            <div class="AttireChooser">
<div class="AttireChooser">
    <h4>My Wardrobe</h4>
    <div class="HeaderPager">
        <div class="AttireCategory">
            <?php
            while ($row = $result->fetch_assoc()) {
                $item_id = $row['item_id'];

                $stmt = $mysqli->prepare("SELECT * FROM catalog WHERE id = ?");
                $stmt->bind_param("i", $item_id);
                $stmt->execute();

                $item = $stmt->get_result()->fetch_assoc();

                echo '
                <span>
                    <div style="display: inline" class="ColorPickerItem">
                        <a id="hat_' . $item_id . '" title="Hat ' . $item_id . '" onclick="location.href=\'/api/equip.ashx?ID=' . $item_id . '\'" style="display:inline-block;height:96px;width:96px;cursor:pointer;">
                            <img src="/Thumbs/Hat.ashx?ID=' . $item_id . '" height="100" width="100" border="0" alt="Hat ' . $item_id . '">
                            ' . $item['name'] . '
                        </a>
                    </div>
                </span>';
            }

            $stmt->close();
            ?>
        </div>
    </div>
    <div class="AttireContent" id="wardrobestuff">
    </div>
</div>

            </div>
            
            <div class="AttireChooser" style="margin-top: 8px;">
                <h4>Currently Wearing</h4>
                <div class="HeaderPager">
                    <div class="AttireContent" id="wardrobestuff2">
                        <p style="padding: 20px; text-align: center;">Soon.</p>
                    </div>
                </div>
            </div>
        </div>
        <br clear="all">
        
        <div id="PopupRightLeg" class="popupControl" style="top: 435px; right: 165px; visibility: hidden;"><table cellspacing="0" border="0" style="border-width:0px;border-collapse:collapse;"><tbody><tr><td><div class="ColorPickerItem" onclick="changebcolor('1', '1');" style="display:inline-block;background-color:#F2F3F3;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('1', '208');" style="display:inline-block;background-color:#E5E4DF;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('1', '194');" style="display:inline-block;background-color:#A3A2A5;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('1', '199');" style="display:inline-block;background-color:#635F62;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('1', '26');" style="display:inline-block;background-color:#1B2A35;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('1', '21');" style="display:inline-block;background-color:#C4281C;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('1', '24');" style="display:inline-block;background-color:#F5CD30;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('1', '226');" style="display:inline-block;background-color:#FDEA8D;height:32px;width:32px;"></div></td></tr><tr><td><div class="ColorPickerItem" onclick="changebcolor('1', '23');" style="display:inline-block;background-color:#0D69AC;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('1', '107');" style="display:inline-block;background-color:#008F9C;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('1', '102');" style="display:inline-block;background-color:#6E99CA;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('1', '11');" style="display:inline-block;background-color:#80BBDC;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('1', '45');" style="display:inline-block;background-color:#B4D2E4;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('1', '135');" style="display:inline-block;background-color:#74869D;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('1', '106');" style="display:inline-block;background-color:#DA8541;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('1', '105');" style="display:inline-block;background-color:#E29B40;height:32px;width:32px;"></div></td></tr><tr><td><div class="ColorPickerItem" onclick="changebcolor('1', '141');" style="display:inline-block;background-color:#27462D;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('1', '28');" style="display:inline-block;background-color:#287F47;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('1', '37');" style="display:inline-block;background-color:#4B974B;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('1', '119');" style="display:inline-block;background-color:#A4BD47;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('1', '29');" style="display:inline-block;background-color:#A1C48C;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('1', '151');" style="display:inline-block;background-color:#789082;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('1', '38');" style="display:inline-block;background-color:#A05F35;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('1', '192');" style="display:inline-block;background-color:#694028;height:32px;width:32px;"></div></td></tr><tr><td><div class="ColorPickerItem" onclick="changebcolor('1', '104');" style="display:inline-block;background-color:#6B327C;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('1', '9');" style="display:inline-block;background-color:#E8BAC8;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('1', '101');" style="display:inline-block;background-color:#DA867A;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('1', '5');" style="display:inline-block;background-color:#D7C59A;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('1', '153');" style="display:inline-block;background-color:#957977;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('1', '217');" style="display:inline-block;background-color:#7C5C46;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('1', '18');" style="display:inline-block;background-color:#CC8E69;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('1', '125');" style="display:inline-block;background-color:#EAB892;height:32px;width:32px;"></div></td></tr></tbody></table></div><div id="PopupHead" class="popupControl" style="top: 435px; right: 165px; visibility: hidden;"><table cellspacing="0" border="0" style="border-width:0px;border-collapse:collapse;"><tbody><tr><td><div class="ColorPickerItem" onclick="changebcolor('2', '1');" style="display:inline-block;background-color:#F2F3F3;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('2', '208');" style="display:inline-block;background-color:#E5E4DF;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('2', '194');" style="display:inline-block;background-color:#A3A2A5;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('2', '199');" style="display:inline-block;background-color:#635F62;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('2', '26');" style="display:inline-block;background-color:#1B2A35;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('2', '21');" style="display:inline-block;background-color:#C4281C;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('2', '24');" style="display:inline-block;background-color:#F5CD30;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('2', '226');" style="display:inline-block;background-color:#FDEA8D;height:32px;width:32px;"></div></td></tr><tr><td><div class="ColorPickerItem" onclick="changebcolor('2', '23');" style="display:inline-block;background-color:#0D69AC;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('2', '107');" style="display:inline-block;background-color:#008F9C;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('2', '102');" style="display:inline-block;background-color:#6E99CA;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('2', '11');" style="display:inline-block;background-color:#80BBDC;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('2', '45');" style="display:inline-block;background-color:#B4D2E4;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('2', '135');" style="display:inline-block;background-color:#74869D;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('2', '106');" style="display:inline-block;background-color:#DA8541;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('2', '105');" style="display:inline-block;background-color:#E29B40;height:32px;width:32px;"></div></td></tr><tr><td><div class="ColorPickerItem" onclick="changebcolor('2', '141');" style="display:inline-block;background-color:#27462D;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('2', '28');" style="display:inline-block;background-color:#287F47;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('2', '37');" style="display:inline-block;background-color:#4B974B;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('2', '119');" style="display:inline-block;background-color:#A4BD47;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('2', '29');" style="display:inline-block;background-color:#A1C48C;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('2', '151');" style="display:inline-block;background-color:#789082;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('2', '38');" style="display:inline-block;background-color:#A05F35;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('2', '192');" style="display:inline-block;background-color:#694028;height:32px;width:32px;"></div></td></tr><tr><td><div class="ColorPickerItem" onclick="changebcolor('2', '104');" style="display:inline-block;background-color:#6B327C;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('2', '9');" style="display:inline-block;background-color:#E8BAC8;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('2', '101');" style="display:inline-block;background-color:#DA867A;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('2', '5');" style="display:inline-block;background-color:#D7C59A;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('2', '153');" style="display:inline-block;background-color:#957977;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('2', '217');" style="display:inline-block;background-color:#7C5C46;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('2', '18');" style="display:inline-block;background-color:#CC8E69;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('2', '125');" style="display:inline-block;background-color:#EAB892;height:32px;width:32px;"></div></td></tr></tbody></table></div><div id="PopupTorso" class="popupControl" style="top: 435px; right: 165px; visibility: hidden;"><table cellspacing="0" border="0" style="border-width:0px;border-collapse:collapse;"><tbody><tr><td><div class="ColorPickerItem" onclick="changebcolor('3', '1');" style="display:inline-block;background-color:#F2F3F3;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('3', '208');" style="display:inline-block;background-color:#E5E4DF;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('3', '194');" style="display:inline-block;background-color:#A3A2A5;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('3', '199');" style="display:inline-block;background-color:#635F62;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('3', '26');" style="display:inline-block;background-color:#1B2A35;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('3', '21');" style="display:inline-block;background-color:#C4281C;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('3', '24');" style="display:inline-block;background-color:#F5CD30;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('3', '226');" style="display:inline-block;background-color:#FDEA8D;height:32px;width:32px;"></div></td></tr><tr><td><div class="ColorPickerItem" onclick="changebcolor('3', '23');" style="display:inline-block;background-color:#0D69AC;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('3', '107');" style="display:inline-block;background-color:#008F9C;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('3', '102');" style="display:inline-block;background-color:#6E99CA;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('3', '11');" style="display:inline-block;background-color:#80BBDC;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('3', '45');" style="display:inline-block;background-color:#B4D2E4;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('3', '135');" style="display:inline-block;background-color:#74869D;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('3', '106');" style="display:inline-block;background-color:#DA8541;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('3', '105');" style="display:inline-block;background-color:#E29B40;height:32px;width:32px;"></div></td></tr><tr><td><div class="ColorPickerItem" onclick="changebcolor('3', '141');" style="display:inline-block;background-color:#27462D;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('3', '28');" style="display:inline-block;background-color:#287F47;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('3', '37');" style="display:inline-block;background-color:#4B974B;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('3', '119');" style="display:inline-block;background-color:#A4BD47;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('3', '29');" style="display:inline-block;background-color:#A1C48C;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('3', '151');" style="display:inline-block;background-color:#789082;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('3', '38');" style="display:inline-block;background-color:#A05F35;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('3', '192');" style="display:inline-block;background-color:#694028;height:32px;width:32px;"></div></td></tr><tr><td><div class="ColorPickerItem" onclick="changebcolor('3', '104');" style="display:inline-block;background-color:#6B327C;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('3', '9');" style="display:inline-block;background-color:#E8BAC8;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('3', '101');" style="display:inline-block;background-color:#DA867A;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('3', '5');" style="display:inline-block;background-color:#D7C59A;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('3', '153');" style="display:inline-block;background-color:#957977;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('3', '217');" style="display:inline-block;background-color:#7C5C46;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('3', '18');" style="display:inline-block;background-color:#CC8E69;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('3', '125');" style="display:inline-block;background-color:#EAB892;height:32px;width:32px;"></div></td></tr></tbody></table></div><div id="PopupLeftArm" class="popupControl" style="top: 435px; right: 165px; visibility: hidden;"><table cellspacing="0" border="0" style="border-width:0px;border-collapse:collapse;"><tbody><tr><td><div class="ColorPickerItem" onclick="changebcolor('4', '1');" style="display:inline-block;background-color:#F2F3F3;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('4', '208');" style="display:inline-block;background-color:#E5E4DF;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('4', '194');" style="display:inline-block;background-color:#A3A2A5;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('4', '199');" style="display:inline-block;background-color:#635F62;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('4', '26');" style="display:inline-block;background-color:#1B2A35;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('4', '21');" style="display:inline-block;background-color:#C4281C;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('4', '24');" style="display:inline-block;background-color:#F5CD30;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('4', '226');" style="display:inline-block;background-color:#FDEA8D;height:32px;width:32px;"></div></td></tr><tr><td><div class="ColorPickerItem" onclick="changebcolor('4', '23');" style="display:inline-block;background-color:#0D69AC;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('4', '107');" style="display:inline-block;background-color:#008F9C;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('4', '102');" style="display:inline-block;background-color:#6E99CA;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('4', '11');" style="display:inline-block;background-color:#80BBDC;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('4', '45');" style="display:inline-block;background-color:#B4D2E4;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('4', '135');" style="display:inline-block;background-color:#74869D;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('4', '106');" style="display:inline-block;background-color:#DA8541;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('4', '105');" style="display:inline-block;background-color:#E29B40;height:32px;width:32px;"></div></td></tr><tr><td><div class="ColorPickerItem" onclick="changebcolor('4', '141');" style="display:inline-block;background-color:#27462D;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('4', '28');" style="display:inline-block;background-color:#287F47;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('4', '37');" style="display:inline-block;background-color:#4B974B;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('4', '119');" style="display:inline-block;background-color:#A4BD47;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('4', '29');" style="display:inline-block;background-color:#A1C48C;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('4', '151');" style="display:inline-block;background-color:#789082;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('4', '38');" style="display:inline-block;background-color:#A05F35;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('4', '192');" style="display:inline-block;background-color:#694028;height:32px;width:32px;"></div></td></tr><tr><td><div class="ColorPickerItem" onclick="changebcolor('4', '104');" style="display:inline-block;background-color:#6B327C;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('4', '9');" style="display:inline-block;background-color:#E8BAC8;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('4', '101');" style="display:inline-block;background-color:#DA867A;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('4', '5');" style="display:inline-block;background-color:#D7C59A;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('4', '153');" style="display:inline-block;background-color:#957977;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('4', '217');" style="display:inline-block;background-color:#7C5C46;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('4', '18');" style="display:inline-block;background-color:#CC8E69;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('4', '125');" style="display:inline-block;background-color:#EAB892;height:32px;width:32px;"></div></td></tr></tbody></table></div><div id="PopupRightArm" class="popupControl" style="top: 435px; right: 165px; visibility: hidden;"><table cellspacing="0" border="0" style="border-width:0px;border-collapse:collapse;"><tbody><tr><td><div class="ColorPickerItem" onclick="changebcolor('5', '1');" style="display:inline-block;background-color:#F2F3F3;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('5', '208');" style="display:inline-block;background-color:#E5E4DF;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('5', '194');" style="display:inline-block;background-color:#A3A2A5;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('5', '199');" style="display:inline-block;background-color:#635F62;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('5', '26');" style="display:inline-block;background-color:#1B2A35;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('5', '21');" style="display:inline-block;background-color:#C4281C;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('5', '24');" style="display:inline-block;background-color:#F5CD30;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('5', '226');" style="display:inline-block;background-color:#FDEA8D;height:32px;width:32px;"></div></td></tr><tr><td><div class="ColorPickerItem" onclick="changebcolor('5', '23');" style="display:inline-block;background-color:#0D69AC;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('5', '107');" style="display:inline-block;background-color:#008F9C;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('5', '102');" style="display:inline-block;background-color:#6E99CA;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('5', '11');" style="display:inline-block;background-color:#80BBDC;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('5', '45');" style="display:inline-block;background-color:#B4D2E4;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('5', '135');" style="display:inline-block;background-color:#74869D;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('5', '106');" style="display:inline-block;background-color:#DA8541;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('5', '105');" style="display:inline-block;background-color:#E29B40;height:32px;width:32px;"></div></td></tr><tr><td><div class="ColorPickerItem" onclick="changebcolor('5', '141');" style="display:inline-block;background-color:#27462D;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('5', '28');" style="display:inline-block;background-color:#287F47;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('5', '37');" style="display:inline-block;background-color:#4B974B;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('5', '119');" style="display:inline-block;background-color:#A4BD47;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('5', '29');" style="display:inline-block;background-color:#A1C48C;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('5', '151');" style="display:inline-block;background-color:#789082;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('5', '38');" style="display:inline-block;background-color:#A05F35;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('5', '192');" style="display:inline-block;background-color:#694028;height:32px;width:32px;"></div></td></tr><tr><td><div class="ColorPickerItem" onclick="changebcolor('5', '104');" style="display:inline-block;background-color:#6B327C;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('5', '9');" style="display:inline-block;background-color:#E8BAC8;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('5', '101');" style="display:inline-block;background-color:#DA867A;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('5', '5');" style="display:inline-block;background-color:#D7C59A;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('5', '153');" style="display:inline-block;background-color:#957977;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('5', '217');" style="display:inline-block;background-color:#7C5C46;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('5', '18');" style="display:inline-block;background-color:#CC8E69;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('5', '125');" style="display:inline-block;background-color:#EAB892;height:32px;width:32px;"></div></td></tr></tbody></table></div><div id="PopupLeftLeg" class="popupControl" style="top: 435px; right: 165px; visibility: hidden;"><table cellspacing="0" border="0" style="border-width:0px;border-collapse:collapse;"><tbody><tr><td><div class="ColorPickerItem" onclick="changebcolor('6', '1');" style="display:inline-block;background-color:#F2F3F3;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('6', '208');" style="display:inline-block;background-color:#E5E4DF;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('6', '194');" style="display:inline-block;background-color:#A3A2A5;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('6', '199');" style="display:inline-block;background-color:#635F62;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('6', '26');" style="display:inline-block;background-color:#1B2A35;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('6', '21');" style="display:inline-block;background-color:#C4281C;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('6', '24');" style="display:inline-block;background-color:#F5CD30;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('6', '226');" style="display:inline-block;background-color:#FDEA8D;height:32px;width:32px;"></div></td></tr><tr><td><div class="ColorPickerItem" onclick="changebcolor('6', '23');" style="display:inline-block;background-color:#0D69AC;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('6', '107');" style="display:inline-block;background-color:#008F9C;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('6', '102');" style="display:inline-block;background-color:#6E99CA;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('6', '11');" style="display:inline-block;background-color:#80BBDC;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('6', '45');" style="display:inline-block;background-color:#B4D2E4;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('6', '135');" style="display:inline-block;background-color:#74869D;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('6', '106');" style="display:inline-block;background-color:#DA8541;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('6', '105');" style="display:inline-block;background-color:#E29B40;height:32px;width:32px;"></div></td></tr><tr><td><div class="ColorPickerItem" onclick="changebcolor('6', '141');" style="display:inline-block;background-color:#27462D;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('6', '28');" style="display:inline-block;background-color:#287F47;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('6', '37');" style="display:inline-block;background-color:#4B974B;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('6', '119');" style="display:inline-block;background-color:#A4BD47;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('6', '29');" style="display:inline-block;background-color:#A1C48C;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('6', '151');" style="display:inline-block;background-color:#789082;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('6', '38');" style="display:inline-block;background-color:#A05F35;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('6', '192');" style="display:inline-block;background-color:#694028;height:32px;width:32px;"></div></td></tr><tr><td><div class="ColorPickerItem" onclick="changebcolor('6', '104');" style="display:inline-block;background-color:#6B327C;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('6', '9');" style="display:inline-block;background-color:#E8BAC8;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('6', '101');" style="display:inline-block;background-color:#DA867A;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('6', '5');" style="display:inline-block;background-color:#D7C59A;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('6', '153');" style="display:inline-block;background-color:#957977;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('6', '217');" style="display:inline-block;background-color:#7C5C46;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('6', '18');" style="display:inline-block;background-color:#CC8E69;height:32px;width:32px;"></div></td><td><div class="ColorPickerItem" onclick="changebcolor('6', '125');" style="display:inline-block;background-color:#EAB892;height:32px;width:32px;"></div></td></tr></tbody></table></div>    </div>
</div>

<script>
function checkIfRendered() {
    $("#avatarthumb").attr(
        "src",
        "/Thumbs/Avatar.ashx?ID=<?= (int)$user['id'] ?>"
    );
}

$(document).ready(function() {
    checkIfRendered();
});

function applyColors(res) {
    const map = {
        headcolor: "HeadSelector",
        torsocolor: "TorsoSelector",
        leftarmcolor: "LeftArmSelector",
        rightarmcolor: "RightArmSelector",
        leftlegcolor: "LeftLegSelector",
        rightlegcolor: "RightLegSelector"
    };

    for (let key in map) {
        const el = document.getElementById(map[key]);
        if (el && res[key] !== undefined) {
            el.style.backgroundColor = getColor(res[key]);
        }
    }
}


function syncColorChooser(res) {
    document.querySelectorAll(".ColorPickerItem").forEach(el => {
        el.classList.remove("selected");
    });

    document.querySelectorAll(".ColorPickerItem").forEach(el => {
        const onclick = el.getAttribute("onclick");
        
        if (!onclick) return;

        for (const key in res) {
            const colorId = res[key];

            if (onclick.includes(`'${colorId}'`)) {
                el.classList.add("selected");
            }
        }
    });
}
</script>

