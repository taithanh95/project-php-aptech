-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Jeu 24 Avril 2014 à 03:50
-- Version du serveur: 5.6.12-log
-- Version de PHP: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `tmdt`
--
CREATE DATABASE IF NOT EXISTS `tmdt` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `tmdt`;

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `fullname` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `sex` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Contenu de la table `admin`
--

INSERT INTO `admin` (`id`, `user`, `password`, `email`, `fullname`, `sex`, `phone`, `address`) VALUES
(1, 'admin', 'e10adc3949ba59abbe56e057f20f883e', 'admin@gmail.com', 'Administrator', 'Nam', '0968686868', 'Hà Nội');

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

CREATE TABLE IF NOT EXISTS `articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `articles_name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `cat_id` int(11) NOT NULL,
  `show` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `comment` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `catid_art` (`cat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Contenu de la table `articles`
--

INSERT INTO `articles` (`id`, `articles_name`, `cat_id`, `show`, `content`, `created`, `comment`) VALUES
(1, 'Những lợi ích bất ngờ của việc đi xe đạp', 10, 'true', '- Cải thiện chức năng tim phổi: Các chuyên gia vận động khoa học cho rằng, đi xe đạp có thể rèn luyện toàn diện các cơ quan trong cơ thể, tăng cường chức năng tim phổi và tăng sức chịu đựng, thúc đẩy trao đổi chất và tuần hoàn máu, làm chậm quá trình lão hóa. Xe đạp cũng được cho là một trong những phương tiện tốt nhất để khắc phục các vấn đề tim phổi.\r<br /><br />\r<br /><br />Vận động bền bỉ lâu dài có thể giúp bão hòa oxy trong máu, giảm các triệu chứng giãn tĩnh mạch, tăng cường sức mạnh cho cơ tim và nhịp tim ổn định hơn, tăng lưu lượng vận chuyển máu gấp 2 – 2,5 lần, kết quả là tim tiêu tốn ít oxy, hiệu quả làm việc cao hơn trong quá trình vận động.\r<br /><br />\r<br /><br />- Tăng cường thể chất và sự nhẫn nại: Tập thể dục bằng cách đi đạp xe là một phương pháp giúp bạn ngày một cải thiện chức năng của cơ bắp. Thường xuyên đi xe đạp giúp tăng cường cơ bắp cho chân và rất tốt cho sự di chuyển của hông và đầu gối.\r<br /><br />\r<br /><br />Dần dần bạn sẽ bắt đầu nhìn thấy sự cải thiện rõ rệt trong các cơ ở chân, đùi và hông. Ngoài ra, đi xe đạp là một cách tốt để xây dựng khả năng chịu đựng. Bởi vì mọi người thích đi xe đạp và họ sẽ không nhận ra rằng càng ngày họ càng có thể đi được xa hơn.\r<br /><br />\r<br /><br />- Cải thiện sức khỏe tâm lý: Đi xe đạp ngoài trời có thể kích thích sức khỏe tâm lý. Kiểu vận động vừa phải này có thể khiến cơ thể bài tiết một loại hormone tên là endorphins β, có thể giúp con người thoát khỏi lo lắng, tinh thần vui vẻ, sảng khoái.\r<br /><br />\r<br /><br />Đồng thời, việc dùng lực toàn thân trong quá trình đạp xe sẽ giúp thu hẹp mạch máu, khiến tuần hoàn máu được đẩy nhanh hơn, não bộ tiêu thụ nhiều oxy hơn, mắt tinh tai thính, tâm trí sáng suốt hơn.\r<br /><br />\r<br /><br />Đạp xe sao cho đúng cách\r<br /><br />\r<br /><br />- Tư thế: Tư thế đi xe đạp sai không chỉ ảnh hưởng đến hiệu quả rèn luyện, mà còn rất dễ làm tổn thương cơ thể. Chẳng hạn như hai chân khuỳnh rộng, cúi đầu, vẹo lưng…đều là những tư thế không chuẩn xác.\r<br /><br />\r<br /><br />Tư thế đúng đó là: Cơ thể hơi nghiêng về phía trước, hai cánh tay duổi thẳng, hóp chặt bụng, dùng cách thở bằng bụng, hai đùi song song với thanh ngang của xe, đầu gối, hông luôn phối hợp nhịp nhàng, đồng thời chú ý tới nhịp điệu đạp xem.\r<br /><br />\r<br /><br />- Động tác: Nhiều người cho rằng, đạp xe chính là chân đạp xuống dưới, bánh xe quay thì đạp. Thực ra, đạp xe chính xác bao gồm 4 động tác thống nhất: đạp, kéo, nâng, đẩy. Chân đạp xuống dưới, bàn chân co lại kéo lên, rồi nâng bàn đạp cuối cùng đẩy xuống, như vậy mới hoàn thành tròn một nhịp đạp xe. Như vậy đạp xe nhịp nhành không chỉ tiết kiệm sức lực mà còn đẩy nhanh tốc độ.\r<br /><br />\r<br /><br />- Tốc độ: Trên thực tế, nhiều người do bận rộn hoặc không để ý nên chỉ đạp xe dưới mức khả năng của mình. Điều này cũng tốt cho sức khỏe, nhưng sẽ là tốt hơn đến 3 lần nếu biết và đạp với hết khả năng của mình. Lấy ví dụ về một buổi đạp xe kéo dài trong 30 phút: 10 phút đầu đạp với tốc độ 20-25 km/h để làm nóng, và cũng là thời gian ra đến đường tập chính, 10 phút sau đó, đạp nhanh hết mức có thể.\r<br /><br />\r<br /><br />Ở giữa giai đoạn này, người tập phải có cảm giác khó thở, đổ mồ hôi, và hơi khó để duy trì vận tốc nhưng đây chính là giai đoạn quan trọng nhất và người tập không nên đạp chậm lại mà cần cố gắng duy trì tốc độ cao nhất càng lâu càng tốt.10 phút cuối là thời gian thả lỏng nên cần đạp chậm để về nhà.\r<br /><br />\r<br /><br />Để đạp xe với tất cả khả năng, người tập nên có một đồng hồ đo thời gian và tốc độ, để so sánh tốc độ cao nhất để đạt được qua mỗi ngày.', '2014-04-06 13:32:53', 'true'),
(2, 'Giữ xương chắc khỏe bằng cách tập đi xe đạp chậm', 10, 'true', 'Để có một sức khỏe tốt, ngoài chế độ dinh dưỡng hợp lý, ngủ đủ giấc và có sức khỏe tinh thần tốt, chúng ta phải thường xuyên tập luyện thể dục, thể thao.\r<br />\r<br />Ai cũng biết tập thể dục,vận động một cách khoa học thì có lợi cho sức khỏe, nhưng không phải ai cũng có điều kiện, có thời gian để làm được điều đó. Trong thời đại ngày nay, khi các phương tiện giao thông hiện đại thay thế cho việc đi bộ, đi xe đạp,… thì có nhiều người mặc dù có thời gian nhưng lại rất lười tập luyện thể dục, thể thao. Chính do lười vận động nên đã tự đặt họ vào trạng thái nguy hiểm tới sức khỏe, nhất là cho hệ xương.\r<br />\r<br />Mình chia sẽ những lợi ích từ việc đi xe đạp nhé:\r<br />\r<br />- Đi xe đạp giúp chúng ta giảm 90% chứng đau nửa đầu. Theo nghiên cứu của các nhà khoa học Thụy Điển nhận thấy: tuân thủ một chương trình đạp xe đều đặn, với cường độ vừa phải sẽ giúp giảm nguy cơ bị đau đầu tới 90%.\r<br />\r<br />- Đi xe đạp tốt cho người bỏ thuốc lá. Một nghiên cứu mới đây của Pháp cho thấy: Những người ngừng hút thuốc lá có thể giữ được cân nặng của mình nhờ vào đi xe đạp đều đặn hàng ngày.\r<br />\r<br />- Chúng ta sẽ tăng cường thể lực khi đi xe đạp. Những lợi ích bạn sẽ nhận thấy là cơ thể được tăng cường lượng ôxy, sức mạnh cơ bắp tăng lên. Theo quan điểm đó, việc đi xe đạp được ưa chuộng như một hoạt động tăng cường sức khỏe cho tim mạch, phổi và mọi người cần phải luyện tập theo một kế hoạch nhất định.\r<br />\r<br />- Giúp hệ xương chắc khỏe, sửa tư thế và dáng xiêu vẹo.\r<br />\r<br />Hình thức tập luyện này giúp chúng ta đặc biệt các bạn nữ giảm cân hiệu quả. Các nghiên cứu đã chỉ ra rằng: mỗi giờ đạp xe có thể giúp cơ thể tiêu thụ 240kcalo (tương đương với 5 giờ đi xe máy). Đây là loại hình vận động nhẹ nhàng nhưng hiệu quả này giúp tăng cường quá trình tuần hoàn máu trong cơ thể. Bạn sẽ luôn có một thân hình cân đối và một sức khoẻ dẻo dai.\r<br />\r<br />Phương pháp: Đạp xe ở mức độ chậm, liên tục trên 20 phút có thể đốt cháy lượng mỡ lớn dư thừa, chính vì thế hình thức luyện tập này rất có lợi với các bạn muốn giảm béo. Nhịp tim: Không vượt quá 65% nhịp tim tối đa.', '2014-04-06 13:29:17', 'true'),
(3, 'Bạn đã biết cách đi xe đạp đúng kỹ thuật chưa?', 10, 'true', 'Bạn có muốn đi bộ ra ngoài hay đạp xe đạp dạo phố không? Có thể bạn thừa biết cách đạp xe, có thể bạn chưa biết cách đi xe? Nếu bạn quan tâm và muốn có một cơ thể khỏe mạnh với hình dáng bắt mắt, hãy đạp xe đạp với những gợi ý dưới đây.\r<br /> \r<br />\r<br />1.Tìm một địa điểm an toàn để tập xe:  Bề mặt bê tông là dễ dàng nhất cho việc luyện tập của bạn , nhưng sẽ rất đau nếu bạn ngã xe. ( Tuy nhiên, với kỹ thuật phanh chính xác cùng việc điều chỉnh yên xe phù hợp thì đây không phải là một vấn đề nghiêm trọng). Nếu bạn sợ cảm giác đau khi ngã trên bề mặt bê tông, bạn có thể tìm nơi bãi cỏ hoặc đường dải sỏi sạch sẽ để tập xe.\r<br />\r<br />2.Hãy đảm bảo rằng bạn biết cách đạp xe an toàn. Nếu đây là lần đầu tiên bạn đi xe đạp,  hãy hạ thấp yên xe xuống sao cho chân của bạn có thể chạm đất khi ngồi trên yên. Bạn nên kiểm tra xe trước khi đi xem bánh xe có đủ hơi không, kiểm tra phanh, xích xe,… Bạn nên mặc quần áo gọn gàng, không rộng thùng thình khi đạp xe, tránh mặc quần quá dài sẽ khiến gấu quần dễ bị mắc vào xích xe.\r<br /> \r<br />\r<br />3.Chú ý cách phanh xe : Khi thực hành, bạn nên chú ý đến cách dùng phanh khi cần thiết\r<br /> \r<br />\r<br />Nếu xe đạp của bạn có phanh ở ghi đông : hãy kiểm tra cái phanh nào điểu khiển lốp sau và cái nào điều khiển lốp trước. Để làm việc này, bạn lật ngửa xe đạp lên, quay bánh xe bằng tay, và kiểm tra cả phanh của cả hai bánh lần lượt. Những người mới thường hay sử dụng phanh sau cho an toàn. Nếu phanh sau hỏng, bạn có thể dùng phanh trước. Bạn cần chú ý động tác từ từ khi dùng phanh trước, tránh phanh gấp.\r<br />\r<br />Nếu xe không có phanh ở ghi đông thì bạn nên dùng phanh ở bàn đạp sau.\r<br />\r<br />4.    Ngồi lên xe :Với yên xe được hạ thấp, việc này rất đơn giản.\r<br />\r<br />5.     Tập giữ thăng bằng khi đi xe: Hãy dựng chân chống xe, ngồi lên yên sao cho chân chạm   đất để cảm nhận cách xe dừng lại và đi như thế nào. Hãy thực hiện động tác này đến khi bạn cảm thấy tự tin, thoải mái về việc đạp xe. Đẩy người về phía trước và lướt thật nhanh để tận hưởng cảm giác vi vu trong gió.\r<br /> \r<br />\r<br />Đi nhanh dễ giữ thăng bằng hơn: Đi quá chậm khi đạp xe sẽ khiến bạn dễ ngã.\r<br />\r<br />Nếu bạn tập xe có người hỗ trợ , hãy để họ giữ đằng sau xe và bạn cố gắng dùng bàn đạp một cách chắc chắn.\r<br />\r<br />6.   Thực hành xuống dốc thoai thoải : Hãy dắt xe lên một con dốc thoai thoải, ngồi lên yên xe ( giữ một hoặc hai chân chạm đất tới khi bạn sẵn sàng), và cho xe từ từ chuyển bánh, cảm giác này sẽ rất tuyệt. Sau khi đã xuống dốc bạn dừng lại, xuống xe và lại dong lên dốc, lặp lại động tác vừa rồi cho tới khi bạn cảm thấy quen với tốc độ, cách giữ thăng bằng.\r<br />\r<br />Khi bạn tự tin hơn bạn có thể đặt chân lên pedal và bắt đầu đạp xe.\r<br />\r<br />Khi đã thành thục với việc đạp xe, bạn nên học đến cách phanh xe nhẹ nhàng khi đi từ trên đồi dốc xuống. Hãy thực hành đến khi bạn thấy mình không phải dùng chân để làm phanh.\r<br />\r<br />Khi bạn đã đạp xe thành thục, biết cách sử dụng phanh trên đường thẳng, hãy tập lái xe sang bên lề đường phải, lề đường bên trái.\r<br />\r<br />Và bây giờ đã đến lúc bạn có thể tự mình đạp xe mà không cần có người đi cùng. Khi mới đi bạn nên đi trên đường thẳng, ít gồ ghề. Sau khi đã đi quen bạn có thể lên dốc/ xuống dốc mà không lo bị ngã hay mất thăng bằng.', '2014-04-06 13:30:09', 'true'),
(4, 'Kinh nghiệm "Phượt" bằng xe đạp', 10, 'true', '"Phượt" bằng xe đạp là loại hình du lịch mới được giới trẻ ưa chuộng trong thời gian gần đây. Không chỉ có điểm mạnh về mặt chi phí hợp lý, du lịch bằng xe đạp còn đem đến những khoảnh khắc du lịch đẹp, những trải nghiệm khó quên cho phượt thủ xe đạp trong hành trình du hí của mình.\r<br />\r<br />Nếu đang dự định làm một chuyến "phượt" bằng xe đạp, bạn nên xem qua những kinh nghiệm được chia sẻ bên dưới để đảm bảo mình có một chuyến đi an toàn và vui vẻ.\r<br />\r<br />Xe đạp nào thích hợp cho "phượt"?\r<br />\r<br />Chức năng của loại xe này là đi trên đường núi dốc, gồ ghề đầy đá và hố lởm chởm. Sử dụng loại xe này, bạn sẽ bớt đi sự lo âu về vấn đề xì lốp, gặp những đoạn đường xấu. Bạn sẽ không ngần ngại chạy qua những đoạn đường đầy đá dăm. Tuy vậy, vì trọng lượng xe này tương đối nặng, bánh xe lại hơi to, nên người sử dụng phải tốn nhiều sức.\r<br />\r<br />Đây không phải là loại xe chạy tốc độ nên thời gian đi trên đường sẽ hơi lâu. Nếu bạn đi xuyên Việt theo kiểu du lịch tự tải, xe của bạn phải có braze-on (bộ phận lắp đặt yên xe dùng cho việc chuyên chở hành lý...). Nên lắp thêm viền chắn cho bánh trước và sau để tránh đất cát văng lên mặt khi đi trong mưa. Để tránh vấn đề gãy nan hoa thường xuyên, bạn nên dùng bánh xe có từ 36 nan hoa trở lên.\r<br />\r<br />Khi sử dụng loại xe này bạn có được điểm lợi về tốc độ, nhưng bù lại, bạn không thể đi quá nhanh ở những đoạn đường xấu, gập ghềnh. Vỏ và ruột xe của loại xe đạp đua lại rất mỏng nên rất dễ bị hỏng khi gặp chướng ngại vật. Nếu sử dụng loại xe này, tốt nhất bạn nên mang thêm vỏ và ruột xe dự phòng. Điểm khác cần lưu ý khi sử dụng loại xe này là phải hết sức cẩn thận trong lúc đi mưa vì xe rất dễ bị trượt.\r<br />\r<br />"Touring bike" được thiết kế cho mục đích du lịch, du mục nên loại xe này không nặng, ngắn đòn như mountain bike và cũng không mảnh khảnh như road bike. Ghi đông, dàng thắng, hệ thống tăng/giảm líp xe đều có chất lượng cao. Ghi đông loại cụp như xe cuốc để người sử dụng dễ thay đổi tư thế điều khiển cho bớt mỏi mệt, bớt cản gió và thư thái hơn trên những đoạn đường dài, lộng gió.\r<br />\r<br />Sườn xe cứng cáp, nhẹ và dài đòn để công việc chuyên chở hành lý không vướng víu, cản trở những vòng đạp. Vành xe rắn chắc vì có từ 36 nan hoa trở lên, vì thế vấn đề gãy nan hoa, cong vành hầu như không xảy ra. Loại bánh xe thích hợp cho du lịch ở Việt Nam là loại 700c x 28, hoặc 700c x 36.\r<br />\r<br />Vận tải hành lý\r<br />\r<br />Nên dùng một cặp giỏ treo và một rương nhỏ phía sau để chứa dụng cụ và đồ dùng cá nhân. Nếu bạn có loại chống thấm nước thì không cần chuẩn bị bọc chống mưa cho hành lý. Chuẩn bị những vật dụng tải phía sau này sẽ cất được gánh nặng hành lý trên đầu tay lái, vừa khó điều khiển lại vừa không an toàn cho bạn.\r<br />\r<br />Dụng cụ cần thiết cho chuyến đi? \r<br />\r<br />Những dụng cụ liệt kê dưới đây được xem là những dụng cụ thiết yếu và không thể thiếu cho một hành trình xa.\r<br />\r<br />- Một hoặc hai ổ khóa dài dùng để khóa tất cả xe của nhóm"phượt"\r<br />\r<br />- 2 cây mỏ lết lớn\r<br />- 1 cây kìm.\r<br />- 1 hệ thống tăng giảm líp ở phía sau\r<br />- 1 bộ dây phanh\r<br />- Một ống bơm nhỏ\r<br />- 3-4 xăm xe\r<br />- Một lốp xe loại cuộn tròn\r<br />- Một bộ dụng cụ tháo lốp xe\r<br />- Một bộ dụng cụ vá xăm xe\r<br />- Một bộ khóa mở ốc nhỏ\r<br />- Một hoặc hai cặp phanh phụ\r<br />- Một bộ vặn nan hoa\r<br />- Một đồ tháo lắp xích và hộp xích\r<br />- Nan hoa xe: mang đúng loại, đúng cỡ.\r<br />- Một khóa xe đạp.\r<br />- Đồng hồ đo tốc độ, đường dài, nhiệt độ...\r<br />\r<br />Hành lý cá nhân nên mang những gì?\r<br />\r<br />Hành trang lí tưởng nhất là từ dưới 15kg. Dựa theo thời gian của chuyến đi mà mà thu xếp hành lí càng gọn nhẹ càng tốt. Hạn chế đem theo quá nhiều các thiết bị điện tử và đồ có giá trị, quý giá.\r<br />\r<br />- Giày: Một đôi giày chạy xe đạp để đường xa đỡ tốn sức; một đôi xăng-đan tiện dụng để có thể "bảnh" hơn khi dừng chân du lịch, tham quan.\r<br />\r<br />- Nón mũ, dụng cụ chống nắng: Một mũ bảo hiểm; Kính đeo mắt loại dùng đi xe đạp, bảo vệ mắt bạn khỏi bụi và nắng; Một lọ kem chống nắng loại tốt, không có kem chống nắng bạn có thể bị cháy nắng đen như một cục than... đá; Vòng đeo đầu để thấm mồ hôi, nếu không, kính râm của bạn sẽ bị mờ vì mồ hôi rỉ xuống.\r<br />\r<br />- Bình chứa nước: Sử dụng một trong hai cách sau để mang theo nước uống trên đường: Sử dụng hai bình đựng nước uống loại treo theo sườn xe, một bình chứa nước lọc, một bình chứa nước tăng lực; Hoặc sử dụng một bình nước và một bị nước, bị nước sẽ chứa nước lọc còn bình thì chứa nước tăng lực.\r<br />\r<br />- Thức ăn, nước uống tăng lực:\r<br />\r<br />Để sẵn trong hành trang bột pha nước tăng lực và thức ăn nhanh đầy dinh dưỡng và calo. Chỉ mang theo vừa đủ cho chuyến đi để tránh vấn đề quá tải. Bột để pha nước tăng lực, tiếp sức, giảm mất nước, và chống "chuột rút" (hydration drink powder hoặc electrolyte drink powder), rất quan trọng ở những chặng đầu và những chặng có khí hậu quá nóng, quá dài và có quá nhiều đồi, đèo.\r<br />\r<br />Thức ăn nhanh như bánh quy mặn, khoai tây chiên, chocopie, sô-cô-la, kẹo lạc, bim bim... Những thức ăn nhanh này rất cần trong những chặng quá dài hoặc nhiều dốc, lắm đèo.\r<br />\r<br />- Quần áo, găng, vớ (tất):\r<br />\r<br />Hai quần dùng để chạy xe đạp giúp "bàn tọa" của bạn đỡ bị phồng vì ngồi cả ngày trên yên xe.\r<br />\r<br />Hai hoặc ba áo chạy xe đạp giúp bạn mát và không mất nước nhiều.\r<br />\r<br />Hai đôi găng tay chạy xe đạp rất cần nếu không bạn sẽ bị phồng cả đôi bàn tay.\r<br />\r<br />Một đôi vớ giữ ấm chân có thể dùng ở mọi thời tiết, giữ ấm và giảm cháy nắng ở đôi chân.\r<br />\r<br />Một đôi găng tay dài có thể phủ cánh tay giữ ấm đôi tay khi đi trong khu vực có thời tiết lạnh và làm giảm cháy nắng ở đôi tay.\r<br />\r<br />Một bộ quần áo đi mưa loại nhẹ dùng đi xe đạp vừa tránh mưa vừa giúp bạn giữ hơi ấm.\r<br />\r<br />Bốn đôi vớ (tất) tốt. Bạn chớ quên điều này vì nếu bạn chỉ có một đôi thì bạn cùng phòng sẽ không... thở được sau một ngày vất vả!\r<br />\r<br />- Đồ lót: Nên mang theo một ít để khi không giặt thì bạn vẫn còn có thể sử dụng tạm đến ba, bốn ngày.\r<br />\r<br />Một đến hai quần đùi để tránh phải "trần như nhộng" trong phòng.Hai áo thun. Dùng để đi ngủ hoặc đi chơi.\r<br />\r<br />Một bộ quần áo gió. Dùng cho các vùng có khí hậu lạnh.\r<br />\r<br />Một bộ quần áo "kiểng". Nên sử dụng loại vải nhẹ, dễ giặt ủi, mau khô. Bạn đừng quên mang theo một bộ quần áo lịch sự để có thể diện khi đi dạo phố, tham quan\r<br />\r<br />- Linh tinh:\r<br />\r<br />Tuy bị xếp vào hàng linh tinh, nhưng thiếu những thứ này e rằng chuyến đi của bạn... khốn khổ đấy nhé!\r<br />\r<br />Một bóp đi du lịch. Dùng cất giữ những giấy tờ quan trọng.\r<br />\r<br />Điện thoại di động và đồ sạc.\r<br />\r<br />Một bàn chải đánh răng, kem đánh răng, chỉ nha khoa.\r<br />\r<br />Thuốc trị bệnh cần thiết như đau bụng, cảm, cúm, nhức đầu, tiêu chảy...Một cuộn giấy đi vệ sinh phòng khi... chưa kịp uống thuốc.\r<br />\r<br />Thuốc chống muỗi.\r<br />\r<br />Một khăn tắm loại nhẹ, dùng khi bạn... hứng tắm biển dọc đường.\r<br />\r<br />Một máy chụp hình nhỏ, nhẹ. Giúp bạn tiện dịp ghi lại cảnh đẹp dọc đường.\r<br />\r<br />Một đèn chớp nhỏ và một đèn pha phòng khi đêm xuống.\r<br />\r<br />Sau cùng là... tiền! Nên mang theo tiền đủ chi dùng cho việc ăn uống, nghỉ ngơi.\r<br />\r<br />Một vài lưu ý nhỏ cần chú ý do một phượt thủ chi sẻ:\r<br />\r<br />- Tham khảo thông tin và lên kế hoạch cẩn thận cho từng ngày hành trình. Tìm hiểu trước những địa điểm ăn uống, dừng chân, và nghỉ đêm. Đến những vùng miền khác, bạn có thể bị "chặt chém" với giá dịch vụ khá cao, nên tìm hiểu và hỏi giá cũng như trả giá nhiệt tình sẽ giúp tiết kiệm được rất nhiều kinh phí.\r<br />\r<br />- Máy ảnh hoặc máy quay nhỏ gọn sẽ rất cần thiết để ghi lại những hình ảnh đẹp của chuyến đi. Một thứ cũng không thể thiếu là bản đồ hoặc thiết bị định vị GPS. Với công nghệ hiện nay thì một chiếc điện thoại nhỏ gọn có tích hợp đầy đủ chức năng trên sẽ là vật bất ly thân tuyệt vời của bạn.\r<br />\r<br />- Hết sức cẩn thận khi tham gia giao thông, đặc biệt là các tỉnh phía Bắc, đường quốc lộ còn khá xấu, xe chạy ẩu. Nên trang bị bảo hộ đầy đủ. Có thể mua bảo hiểm du lịch nếu bạn đi dài ngày. Không nên đi vào buổi tối, hoặc đi những cung đường vắng vẻ mà không có người đi cùng.\r<br />\r<br />-  Nên có bạn đồng hành trong chuyến đi, trừ khi bạn thực sự có thể tự lập và thích khám phá một mình.\r<br />\r<br />- Giữ tinh thần vui vẻ lạc quan. Giao tiếp nhiều với dân địa phương sẽ mang lại cho bạn nhiều khám phá thú vị.', '2014-04-07 22:08:14', 'true');

-- --------------------------------------------------------

--
-- Structure de la table `articles_comment`
--

CREATE TABLE IF NOT EXISTS `articles_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `art_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` text COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `artid_artcomment` (`art_id`),
  KEY `userid_artcomment` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `show` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=15 ;

--
-- Contenu de la table `categories`
--

INSERT INTO `categories` (`id`, `cat_name`, `show`) VALUES
(2, 'Xe đạp địa hình Land Rover', 'true'),
(3, 'Xe đạp địa hình Hummer', 'true'),
(4, 'Xe đạp địa hình BMW', 'true'),
(5, 'Xe đạp địa hình Fix Gear', 'true'),
(6, 'Xe đạp địa hình Giant', 'true'),
(13, 'Xe đạp địa hình Single', 'true'),
(14, 'Xe đạp địa hình Vogue', 'true');

-- --------------------------------------------------------

--
-- Structure de la table `categorie_articles`
--

CREATE TABLE IF NOT EXISTS `categorie_articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `show` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

--
-- Contenu de la table `categorie_articles`
--

INSERT INTO `categorie_articles` (`id`, `cat_name`, `show`) VALUES
(10, 'Chuyện xe đạp', 'true');

-- --------------------------------------------------------

--
-- Structure de la table `contacts`
--

CREATE TABLE IF NOT EXISTS `contacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `sex` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `lesson_order`
--

CREATE TABLE IF NOT EXISTS `lesson_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `fullname` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `office` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `cmnd` varchar(13) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `sex` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `choosepayment` tinyint(4) NOT NULL,
  `number_account` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `total` float NOT NULL,
  `date` datetime NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userid_order` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `lesson_order_detail`
--

CREATE TABLE IF NOT EXISTS `lesson_order_detail` (
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` float NOT NULL,
  `qty` tinyint(4) NOT NULL,
  PRIMARY KEY (`order_id`,`product_id`),
  KEY `proid_orderdetail` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pro_name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `cat_id` int(11) NOT NULL,
  `price` float NOT NULL,
  `vat` tinyint(4) NOT NULL,
  `baohanh` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `show` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `img` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `comment` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `catid_pro` (`cat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=23 ;

--
-- Contenu de la table `products`
--

INSERT INTO `products` (`id`, `pro_name`, `cat_id`, `price`, `vat`, `baohanh`, `show`, `img`, `content`, `comment`, `created`) VALUES
(7, 'Single nan hoa 7 màu FULL', 13, 2500000, 1, '2', 'true', 'single-nan-hoa-7-mau.jpg', '', 'true', '2014-04-05 10:22:03'),
(8, 'Single khung to màu 3D FULL', 13, 3500000, 1, '2', 'true', 'single-khung-to-mau-3d.jpg', '', 'true', '2014-04-05 15:46:30'),
(9, 'Land Rover FULL', 2, 6000000, 1, '2', 'true', 'land-rover-full.jpg', '', 'true', '2014-04-05 15:46:56'),
(10, 'Land Rover (phanh đĩa)', 2, 6000000, 1, '1', 'true', 'land-rover-phanh-dia.jpg', '', 'true', '2014-04-05 15:47:12'),
(11, 'Hummer FULL', 3, 3000000, 1, '2', 'true', 'hummer-full.jpg', '', 'true', '2014-04-05 15:47:24'),
(12, 'Hummer (phanh đĩa)', 3, 3000000, 1, '2', 'true', 'hummer-phanh-dia.jpg', '', 'true', '2014-04-05 15:47:38'),
(13, 'BMW Power FULL', 4, 3000000, 1, '2', 'true', 'bmw-power-full.jpg', '', 'true', '2014-04-05 15:47:51'),
(14, 'BMW Power 2013 FULL (phanh đĩa)', 4, 4000000, 1, '2', 'true', 'bmw-power-2013-phanh-dia.jpg', '', 'true', '2014-04-05 15:48:07'),
(15, 'BMW x7 (phanh đĩa)', 4, 4500000, 1, '2', 'true', 'bmw-x7-2013-phanh-dia.jpg', '', 'true', '2014-04-05 15:48:19'),
(16, 'BMW King 2013 (phanh đĩa)', 4, 4000000, 1, '2', 'true', 'bmw-king-2013.jpg', '', 'true', '2014-04-05 15:48:40'),
(17, 'BMW Power (phanh cơ)', 4, 2000000, 1, '2', 'true', 'bmw-powe.jpg', '', 'true', '2014-04-05 15:48:52'),
(18, 'Fix Gear (phanh ngược)', 5, 2000000, 1, '2', 'true', 'fix-gear.jpg', '', 'true', '2014-04-05 15:49:07'),
(19, 'GianT 777 FULL', 6, 5000000, 1, '2', 'true', 'giant-777.jpg', '', 'true', '2014-04-05 15:49:22'),
(20, 'GianT 770 FULL', 6, 5000000, 1, '2', 'true', 'giant-770.jpg', '', 'true', '2014-04-05 15:49:34'),
(21, 'Giant ATX7 (phanh đĩa)', 6, 4000000, 1, '2', 'true', 'giant-atx-7.jpg', '', 'true', '2014-04-05 15:49:45'),
(22, 'Xe đạp địa hình Vogue', 14, 2000000, 1, '2', 'true', 'vogue-g4-moutain.jpg', '', 'true', '2014-04-07 20:06:09');

-- --------------------------------------------------------

--
-- Structure de la table `products_comment`
--

CREATE TABLE IF NOT EXISTS `products_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pro_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` text COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `proid_comment` (`pro_id`),
  KEY `userid_comment` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `title` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `home` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `page` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `settings`
--

INSERT INTO `settings` (`title`, `home`, `email`, `page`) VALUES
('Thương mại điện tử', 'http://localhost/project', 'admin@gmail.com', 6);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `fullname` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `sex` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `registed` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `user`, `password`, `email`, `fullname`, `sex`, `phone`, `address`, `registed`) VALUES
(4, 'member', 'e10adc3949ba59abbe56e057f20f883e', 'nva@gmail.com', 'Nguyễn Văn A', 'Nam', '123456789', 'Hà Nội', '2014-04-10 21:09:35');

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `catid_art` FOREIGN KEY (`cat_id`) REFERENCES `categorie_articles` (`id`);

--
-- Contraintes pour la table `articles_comment`
--
ALTER TABLE `articles_comment`
  ADD CONSTRAINT `artid_artcomment` FOREIGN KEY (`art_id`) REFERENCES `articles` (`id`),
  ADD CONSTRAINT `userid_artcomment` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `lesson_order`
--
ALTER TABLE `lesson_order`
  ADD CONSTRAINT `userid_order` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `lesson_order_detail`
--
ALTER TABLE `lesson_order_detail`
  ADD CONSTRAINT `orderid_orderdetail` FOREIGN KEY (`order_id`) REFERENCES `lesson_order` (`id`),
  ADD CONSTRAINT `proid_orderdetail` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Contraintes pour la table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `catid_pro` FOREIGN KEY (`cat_id`) REFERENCES `categories` (`id`);

--
-- Contraintes pour la table `products_comment`
--
ALTER TABLE `products_comment`
  ADD CONSTRAINT `proid_comment` FOREIGN KEY (`pro_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `userid_comment` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
