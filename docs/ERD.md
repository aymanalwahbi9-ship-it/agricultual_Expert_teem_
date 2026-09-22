# مخطط الكيانات والعلاقات لقاعدة بيانات نظام الخبير الزراعي

## 1. الغرض من المخطط

يوضح هذا الملف العلاقات بين جداول قاعدة بيانات نظام الخبير الزراعي. قُسّم المخطط إلى ثلاثة أجزاء حتى تكون الجداول والعلاقات واضحة عند عرضها داخل GitHub.

## 2. مخطط المعرفة والمحاصيل

يوضح هذا الجزء المحاصيل والحالات والأعراض وقاعدة المعرفة والتوصيات وقواعد التربة.

```mermaid
%%{init: {"theme":"base", "themeVariables":{"background":"#ffffff", "primaryColor":"#ffffff", "primaryTextColor":"#111827", "primaryBorderColor":"#111827", "lineColor":"#374151", "fontSize":"14px"}}}%%
erDiagram
    CROPS ||--o{ CROP_CONDITIONS : includes
    CONDITIONS ||--o{ CROP_CONDITIONS : applies_to
    CONDITIONS ||--o{ CONDITION_SYMPTOMS : has
    SYMPTOMS ||--o{ CONDITION_SYMPTOMS : describes
    CROPS ||--o{ KNOWLEDGE_ENTRIES : relates_to
    CONDITIONS ||--o{ KNOWLEDGE_ENTRIES : explains
    CROPS ||--o{ SOIL_RULES : defines
    CONDITIONS ||--o{ RECOMMENDATIONS : supports
    KNOWLEDGE_ENTRIES ||--o{ RECOMMENDATIONS : documents

    CROPS {
        bigint id PK
        varchar name_ar
        boolean is_active
    }
    CONDITIONS {
        bigint id PK
        varchar name_ar
        varchar type
        boolean is_active
    }
    CROP_CONDITIONS {
        bigint id PK
        bigint crop_id FK
        bigint condition_id FK
    }
    SYMPTOMS {
        bigint id PK
        varchar name_ar
    }
    CONDITION_SYMPTOMS {
        bigint id PK
        bigint condition_id FK
        bigint symptom_id FK
        decimal weight
    }
    KNOWLEDGE_ENTRIES {
        bigint id PK
        bigint crop_id FK
        bigint condition_id FK
        varchar content_type
        varchar source_name
        date reviewed_at
    }
    SOIL_RULES {
        bigint id PK
        bigint crop_id FK
        varchar element
        decimal suitable_min
        decimal suitable_max
    }
    RECOMMENDATIONS {
        bigint id PK
        bigint condition_id FK
        bigint knowledge_entry_id FK
        varchar title_ar
    }
```

## 3. مخطط مدخلات التشخيص

يوضح هذا الجزء العملية التي تبدأ عند اختيار المحصول، ثم حفظ الصورة وقراءة التربة وتصنيف عناصرها.

```mermaid
%%{init: {"theme":"base", "themeVariables":{"background":"#ffffff", "primaryColor":"#ffffff", "primaryTextColor":"#111827", "primaryBorderColor":"#111827", "lineColor":"#374151", "fontSize":"14px"}}}%%
erDiagram
    CROPS ||--o{ DIAGNOSIS_CASES : selected_for
    DIAGNOSIS_CASES ||--o{ IMAGE_OBSERVATIONS : contains
    DIAGNOSIS_CASES ||--o{ SOIL_READINGS : contains
    SOIL_READINGS ||--o{ SOIL_ASSESSMENTS : produces
    SOIL_RULES ||--o{ SOIL_ASSESSMENTS : classifies
    CONDITIONS ||--o{ IMAGE_OBSERVATIONS : predicts
    CROPS ||--o{ SOIL_RULES : defines

    CROPS {
        bigint id PK
        varchar name_ar
        boolean is_active
    }
    DIAGNOSIS_CASES {
        bigint id PK
        bigint crop_id FK
        varchar operation_type
        varchar status
        timestamp started_at
    }
    IMAGE_OBSERVATIONS {
        bigint id PK
        bigint diagnosis_case_id FK
        bigint condition_id FK
        varchar source
        decimal confidence
        varchar quality_status
    }
    SOIL_READINGS {
        bigint id PK
        bigint diagnosis_case_id FK
        varchar source
        decimal nitrogen
        decimal phosphorus
        decimal potassium
        decimal ph
        decimal moisture
        decimal temperature
    }
    SOIL_ASSESSMENTS {
        bigint id PK
        bigint soil_reading_id FK
        bigint rule_id FK
        varchar element
        varchar status
    }
    SOIL_RULES {
        bigint id PK
        bigint crop_id FK
        varchar element
        decimal suitable_min
        decimal suitable_max
    }
    CONDITIONS {
        bigint id PK
        varchar name_ar
        varchar type
    }
```

## 4. مخطط النتائج والسجل

يوضح هذا الجزء النتيجة التي يعرضها النظام، ومصادر المعرفة التي دعمتها، وسجل العملية.

```mermaid
%%{init: {"theme":"base", "themeVariables":{"background":"#ffffff", "primaryColor":"#ffffff", "primaryTextColor":"#111827", "primaryBorderColor":"#111827", "lineColor":"#374151", "fontSize":"14px"}}}%%
erDiagram
    DIAGNOSIS_CASES ||--o{ DIAGNOSIS_RESULTS : produces
    CONDITIONS ||--o{ DIAGNOSIS_RESULTS : indicates
    DIAGNOSIS_RESULTS ||--o{ DIAGNOSIS_RESULT_SOURCES : cites
    KNOWLEDGE_ENTRIES ||--o{ DIAGNOSIS_RESULT_SOURCES : supports
    DIAGNOSIS_CASES ||--o{ HISTORY_RECORDS : recorded_in

    DIAGNOSIS_CASES {
        bigint id PK
        bigint crop_id FK
        varchar operation_type
        varchar status
        timestamp completed_at
    }
    CONDITIONS {
        bigint id PK
        varchar name_ar
        varchar type
    }
    KNOWLEDGE_ENTRIES {
        bigint id PK
        bigint crop_id FK
        bigint condition_id FK
        varchar title_ar
        varchar source_name
    }
    DIAGNOSIS_RESULTS {
        bigint id PK
        bigint diagnosis_case_id FK
        bigint condition_id FK
        varchar result_type
        decimal confidence
        varchar status
        text explanation_ar
    }
    DIAGNOSIS_RESULT_SOURCES {
        bigint id PK
        bigint diagnosis_result_id FK
        bigint knowledge_entry_id FK
        decimal match_score
    }
    HISTORY_RECORDS {
        bigint id PK
        bigint diagnosis_case_id FK
        varchar operation_type
        text summary_ar
        timestamp occurred_at
    }
```

## 5. قراءة العلاقات

يرتبط المحصول بالحالات الزراعية من خلال `CROP_CONDITIONS`، وترتبط الحالات بالأعراض من خلال `CONDITION_SYMPTOMS`. وتخزن `KNOWLEDGE_ENTRIES` المعلومات الموثقة التي يستخدمها البحث ومحرك القرار.

تمثل `DIAGNOSIS_CASES` عملية تشخيص واحدة. ويمكن أن تحتوي العملية على صورة أو قراءة تربة أو كليهما. وتنتج عملية التشخيص سجلًا أو أكثر من النتائج، وترتبط النتيجة بالمصادر التي دعمتها عبر `DIAGNOSIS_RESULT_SOURCES`.

## 6. ملاحظات التصميم

تستخدم أسماء الجداول بصيغة الجمع وبالإنجليزية بما يتوافق مع اصطلاحات Laravel. ولا يتضمن الإصدار الحالي جدولًا للمستخدمين؛ لأن نطاق المشروع يعتمد على مستخدم زراعي واحد وسجل محلي.

تظهر الجداول المشتركة في أكثر من مخطط عند الحاجة إلى توضيح العلاقة. ولا يعني تكرار الجدول إنشاءه أكثر من مرة في قاعدة البيانات.

## المراجع

[1]: https://github.com/aymanalwahbi9-ship-it/agricultural-expert-se-project/blob/main/docs/DATABASE_DESIGN.md "وثيقة تصميم قاعدة بيانات نظام الخبير الزراعي"
[2]: https://github.com/aymanalwahbi9-ship-it/agricultural-expert-se-project/blob/main/docs/SYSTEM_DESIGN.md "وثيقة تصميم نظام الخبير الزراعي"
[3]: https://github.com/aymanalwahbi9-ship-it/agricultural-expert-se-project/blob/main/docs/USE_CASE_ANALYSIS.md "وثيقة تحليل حالات استخدام نظام الخبير الزراعي"
