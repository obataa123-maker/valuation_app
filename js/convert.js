numeral = {
            sne: [
                "мянга",
                "сая",
                "тэр бум",
                "наяд",
                "маш дэлгэмэл",
                "тунамал",
                "ингүүмэл",
                "хямралгүй",
                "ялгаруулагч",
                "өвөр дээр",
                "хөөн удирдагч",
                "хязгаар үзэгдэл ",
                "шалтгааны зүйл",
                "үзэсгэлэнт гэрэлт",
                "эрхэт",
                "сайтар хүргэсэн",
                "онон одох",
                "живэх тоосон",
                "бэлэг тэмдэг",
                "хүчин нөхөр",
                "дохио мэдэхүй",
                "тийн болсон",
                "хүчин нүдэн",
                "асрангуй",
                "нигүүлсэнгүй",
                "баясангуй",
                "тэгш",
                "тоомьгүй",
                "хэмжээлшгүй",
                "цаглашгүй",
                "өгүүлшгүй",
                "хирлэшгүй",
                "үлэшгүй",
                "үлэж дуусашгүй",
                "сэтгэшгүй"
            ],

            //unity numeral
            un: [
                "",
                "нэг",
                "хоёр",
                "гурав",
                "дөрөв",
                "тав",
                "зургаа",
                "долоо",
                "найм",
                "ес"
            ],

            //bander unity numeral
            unb: [
                "",
                "нэгэн",
                "хоёр",
                "гурван",
                "дөрвөн",
                "таван",
                "зургаан",
                "долоон",
                "найман",
                "есөн"
            ],

            //decimal numeral
            dn: [
                "",
                "арав",
                "хорь",
                "гуч",
                "дөч",
                "тавь",
                "жар",
                "дал",
                "ная",
                "ер",
            ],

            //bander decimal numeral
            dnb: [
                "",
                "арван",
                "хорин",
                "гучин",
                "дөчин",
                "тавин",
                "жаран",
                "далан",
                "наян",
                "ерэн"
            ],

            //centurion numeral
            cn: [
                "зуу"
            ],

            //bander centurion numeral
            cnb: [
                "зуун"
            ]
        };

        chainer = (num) => {
            let name = ''
            let counter = 0
            let n = num.split('').reverse().join('')
            n = n.match(/.{1,3}/g).map((m) => m.split('').reverse().join('')).reverse()
            name = inhundred(n.pop(), true) + name

            while (n.length) {
                let pop = n.pop()

                if (pop !== '000') {
                    name = inhundred(pop) + numeral.sne[counter] + ' ' + name
                }

                counter += 1
            }

            return name.trim().replace(/ +/g, ' ')
        }

        inhundred = (num, islast=false) => {
            let name = ''
            let n = ('000'+num).match(/.{3}$/g)[0]

            if (n === '001') {
                if (islast) {
                    name = numeral.un[n[2]]
                }
            } else {
                if (n[0] !== '0') {
                    if (n[0] !== '1') {
                        name += numeral.unb[n[0]] + ' '
                    }

                    if (islast && n[1] === '0' && n[2] === '0') {
                        name += numeral.cn + ' '
                    } else {
                        name += numeral.cnb + ' '
                    }
                }

                if (n[1] !== '0') {
                    name += numeral.dnb[n[1]] + ' '
                }

                if (islast) {
                    name += numeral.un[n[2]] + ' '
                } else {
                    name += numeral.unb[n[2]] + ' '
                }
            }

            return name
        }

        function startApp() {
            document.getElementById("numeral_out").innerHTML = chainer(document.getElementById("numeral_in").value);
        }
startApp();