# Setup Cron untuk Production

## Untuk Linux/Unix Server

Tambahkan cron job berikut ke crontab:

```bash
* * * * * cd /path/to/bayarno && php artisan schedule:run >> /dev/null 2>&1
```

Untuk edit crontab:
```bash
crontab -e
```

## Untuk Windows (Task Scheduler)

1. Buka Task Scheduler
2. Create Basic Task
3. Trigger: Daily, repeat every 1 minute
4. Action: Start a program
5. Program: `C:\path\to\php.exe`
6. Arguments: `artisan schedule:run`
7. Start in: `C:\path\to\bayarno`

## Scheduled Tasks

- **Auto Return Phone**: Setiap menit
- **Sync Siswa API**: Setiap X menit (sesuai setting `api_sync_interval_minutes`)

## Test Manual

```bash
php artisan schedule:run
php artisan auto:return-phone
php artisan sync:siswa
```
