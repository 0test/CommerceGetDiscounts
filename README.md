# CommerceGetDiscounts 
Показать скидки у товаров, использующих скидочную систему от https://github.com/webber12/CommerceDiscounts
Два варианта вызова, для показа скидки на конкретный товар и на группу товаров
```
[!CommerceGetDiscounts?
&id=`[*id*]`
&action=`item`
&itemTpl=`@CODE: <div class="disc item_disc">Скидка на этот товар [+name+] [+discount_summ+] руб</div>`
!]
```
```
[!CommerceGetDiscounts?
&id=`[*id*]`
&action=`groups`
&itemTpl=`@CODE:<div class="disc grp_disc">Скидка на всю группу товаров [+name+] [+discount+]%</div>`
!]
```
