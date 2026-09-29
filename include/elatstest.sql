select * from peribadi where jabatan = 'Jabatan Teknologi Maklumat' 

SELECT k.valid, n.namapegawai, n.nokp, n.skim_khidmat, n.gredhakiki, n.jabatan, n.kumpulan, n.status
FROM peribadi n, kursus k
WHERE n.jabatan = 'Jabatan Teknologi Maklumat'
AND n.nokp NOT IN (SELECT k.nokp FROM kursus k)
GROUP BY n.namapegawai

select kursus.nokp2,peribadi.nokp,peribadi.namapegawai,peribadi.jabatan,nama_kursus,kursus.tarikh_mula,kursus.tarikh_tamat from kursus
right join peribadi
on kursus.nokp2=peribadi.nokp
where peribadi.jabatan='Jabatan Teknologi Maklumat'
group by peribadi.nokp
union distinct
select kursus.nokp2,peribadi.nokp,peribadi.namapegawai,peribadi.jabatan,nama_kursus,kursus.tarikh_mula,kursus.tarikh_tamat from kursus
right join peribadi
on kursus.nokp2=peribadi.nokp
where peribadi.jabatan='Jabatan Teknologi Maklumat'
AND kursus.tarikh_mula BETWEEN '2014-01-01' AND '2014-05-30'
AND kursus.tarikh_tamat BETWEEN '2014-01-01' AND '2014-05-30'
group by peribadi.nokp
order by namapegawai

select kursus.nokp,peribadi.nokp,peribadi.namapegawai,peribadi.jabatan,nama_kursus,kursus.tarikh_mula,kursus.tarikh_tamat from kursus
right join peribadi
on kursus.nokp=peribadi.nokp
where peribadi.jabatan='Jabatan Teknologi Maklumat'
AND kursus.tarikh_mula BETWEEN '2014-01-01' AND '2014-05-30'
AND kursus.tarikh_tamat BETWEEN '2014-01-01' AND '2014-05-30'
order by namapegawai

select nokp,namapegawai, jabatan,nama_kursus,tarikh_mula,tarikh_tamat from (
select * from kursus k,peribadi p where k.nokp2=p.nokp AND p.jabatan = 'Jabatan Teknologi Maklumat'
group by namapegawai
union distinct
select * from kursus k, peribadi p WHERE p.jabatan = 'Jabatan Teknologi Maklumat'
AND p.nokp NOT IN (SELECT k.nokp2 FROM kursus k)
group by p.namapegawai
) as target
where jabatan = 'Jabatan Teknologi Maklumat'

select nama_kursus, tarikh_mula from kursus where nokp2='820118-03-5430'
select nama_kursus, tarikh_mula,tarikh_tamat,total_jam from kursus where nokp2='840530-10-5304'

select tarikh_mula,namapegawai,hari  from (
select kursus.nokp2,peribadi.nokp,peribadi.namapegawai,peribadi.jabatan,nama_kursus,kursus.tarikh_mula,kursus.tarikh_tamat,sum(kursus.total_jam) DIV 6 as hari, MOD(sum(kursus.total_jam),6) as jam_tinggal,sum(kursus.total_jam) as jumlah_jam from kursus
right join peribadi
on kursus.nokp2=peribadi.nokp
where peribadi.jabatan='Jabatan Teknologi Maklumat'
group by peribadi.nokp
union
select kursus.nokp2,peribadi.nokp,peribadi.namapegawai,peribadi.jabatan,nama_kursus,kursus.tarikh_mula,kursus.tarikh_tamat,sum(kursus.total_jam) DIV 6 as hari, MOD(sum(kursus.total_jam),6) as jam_tinggal,sum(kursus.total_jam) as jumlah_jam from kursus
right join peribadi
on kursus.nokp2=peribadi.nokp
where peribadi.jabatan='Jabatan Teknologi Maklumat'
AND kursus.tarikh_mula BETWEEN '2014-01-01' AND '2014-05-30'
AND kursus.tarikh_tamat BETWEEN '2014-01-01' AND '2014-05-30'
group by peribadi.nokp
order by namapegawai
) as merge_result
where tarikh_mula is null or tarikh_mula BETWEEN '2014-01-01' AND '2014-06-30'

select tarikh_mula,namapegawai,sum(total_jam) DIV 6 as hari from (
select kursus.nokp,peribadi.nokp,peribadi.namapegawai,peribadi.jabatan,nama_kursus,kursus.tarikh_mula,kursus.tarikh_tamat from kursus
right join peribadi
on nokp2=peribadi.nokp
where peribadi.jabatan='Jabatan Teknologi Maklumat'
group by peribadi.nokp
union distinct
select kursus.nokp,peribadi.nokp,peribadi.namapegawai,peribadi.jabatan,nama_kursus,kursus.tarikh_mula,kursus.tarikh_tamat from kursus
right join peribadi
on kursus.nokp=peribadi.nokp
where peribadi.jabatan='Jabatan Teknologi Maklumat'
AND kursus.tarikh_mula BETWEEN '2014-01-01' AND '2014-05-30'
AND kursus.tarikh_tamat BETWEEN '2014-01-01' AND '2014-05-30'
group by peribadi.nokp
order by namapegawai
) as merge_result
where tarikh_mula is null or tarikh_mula not BETWEEN '2014-01-01' AND '2014-06-30'

SELECT k.valid, n.namapegawai, n.nokp, n.skim_khidmat,n.gredhakiki, n.kumpulan,n.jabatan,n.status, sum(k.total_jam) DIV 6 as hari, MOD(sum(k.total_jam),6) as jam_tinggal 							
FROM peribadi n, kursus k
WHERE k.nokp2 = n.nokp
AND n.jabatan='Jabatan Teknologi Maklumat' AND k.valid = 1
AND k.tarikh_mula BETWEEN '2014-01-01' AND '2014-06-30'
AND k.tarikh_tamat BETWEEN '2014-01-01' AND '2014-06-30'
GROUP BY n.nokp
having hari < 8
ORDER BY k.total_jam

select kursus.nokp2,peribadi.nokp,peribadi.namapegawai,peribadi.jabatan,nama_kursus,kursus.tarikh_mula,kursus.tarikh_tamat,sum(kursus.total_jam) DIV 6 as hari, MOD(sum(kursus.total_jam),6) as jam_tinggal,sum(kursus.total_jam) as jumlah_jam from kursus
right join peribadi
on kursus.nokp2=peribadi.nokp
where peribadi.jabatan='Jabatan Teknologi Maklumat'
and peribadi.nokp = '790816-08-5895'
group by peribadi.nokp
union
select kursus.nokp2,peribadi.nokp,peribadi.namapegawai,peribadi.jabatan,nama_kursus,kursus.tarikh_mula,kursus.tarikh_tamat,sum(kursus.total_jam) DIV 6 as hari, MOD(sum(kursus.total_jam),6) as jam_tinggal,sum(kursus.total_jam) as jumlah_jam from kursus
right join peribadi
on kursus.nokp2=peribadi.nokp
where peribadi.jabatan='Jabatan Teknologi Maklumat'
AND kursus.tarikh_mula BETWEEN '2014-01-01' AND '2014-05-30'
AND kursus.tarikh_tamat BETWEEN '2014-01-01' AND '2014-05-30'
and peribadi.nokp = '790816-08-5895'
group by peribadi.nokp
order by namapegawai

select kursus.nokp2,peribadi.nokp,peribadi.namapegawai,peribadi.jabatan,nama_kursus,kursus.tarikh_mula,kursus.tarikh_tamat,sum(kursus.total_jam) DIV 6 as hari, MOD(sum(kursus.total_jam),6) as jam_tinggal,sum(kursus.total_jam) as jumlah_jam from kursus
right join peribadi
on kursus.nokp2=peribadi.nokp
where peribadi.jabatan='Jabatan Teknologi Maklumat'
AND (kursus.tarikh_mula BETWEEN '2014-01-01' AND '2014-05-30'
AND kursus.tarikh_tamat BETWEEN '2014-01-01' AND '2014-05-30')
OR kursus.tarikh_mula is null
group by peribadi.nokp
union
select kursus.nokp2,peribadi.nokp,peribadi.namapegawai,peribadi.jabatan,nama_kursus,kursus.tarikh_mula,kursus.tarikh_tamat,sum(kursus.total_jam) DIV 6 as hari, MOD(sum(kursus.total_jam),6) as jam_tinggal,sum(kursus.total_jam) as jumlah_jam from kursus
right join peribadi
on kursus.nokp2=peribadi.nokp
where peribadi.jabatan='Jabatan Teknologi Maklumat'
group by peribadi.nokp
order by namapegawai

and peribadi.nokp = '790816-08-5895'

create view kursusitd as
select kursus.nokp2,peribadi.nokp,peribadi.namapegawai,peribadi.jabatan,nama_kursus,kursus.tarikh_mula,kursus.tarikh_tamat,sum(kursus.total_jam) DIV 6 as hari, MOD(sum(kursus.total_jam),6) as jam_tinggal,sum(kursus.total_jam) as jumlah_jam from kursus
right join peribadi
on kursus.nokp2=peribadi.nokp
where peribadi.jabatan='Jabatan Teknologi Maklumat'
group by peribadi.nokp
order by namapegawai

select * from kursusitd

create view peribadikursus as
select kursus.nokp2,peribadi.nokp,peribadi.namapegawai,peribadi.jabatan,nama_kursus,kursus.tarikh_mula,kursus.tarikh_tamat,total_jam from kursus
right join peribadi
on kursus.nokp2=peribadi.nokp
where jabatan='Jabatan Teknologi Maklumat'
and kursus.nokp2 is null

select *,sum(total_jam) as jumlahjam,sum(total_jam) DIV 6 as hari from peribadikursus
where jabatan='Jabatan Teknologi Maklumat'
and tarikh_mula BETWEEN '2014-01-01' AND '2014-05-30'
AND tarikh_tamat BETWEEN '2014-01-01' AND '2014-05-30'
group by namapegawai
having jumlahjam < 32
union
select *,sum(total_jam) as jumlahjam,sum(total_jam) DIV 6 as hari from peribadikursus
where jabatan='Jabatan Teknologi Maklumat'
and nokp2 is null
group by namapegawai
union
select *,sum(total_jam) as jumlahjam,sum(total_jam) DIV 6 as hari from peribadikursus
where jabatan='Jabatan Teknologi Maklumat'
and namapegawai not in 
(select namapegawai from peribadikursus where jabatan='Jabatan Teknologi Maklumat'
and tarikh_mula BETWEEN '2014-01-01' AND '2014-05-30'
AND tarikh_tamat BETWEEN '2014-01-01' AND '2014-05-30'
group by namapegawai)
group by namapegawai


select *,sum(total_jam) as jumlahjam from peribadikursus
where jabatan='Jabatan Teknologi Maklumat'
group by namapegawai

AND (tarikh_mula BETWEEN '2014-01-01' AND '2014-05-30'
AND tarikh_tamat BETWEEN '2014-01-01' AND '2014-05-30')
AND nokp2 is null
group by nokp
order by namapegawai


			

