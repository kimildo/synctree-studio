# Synctree Studio

## 기본 컨셉
> - 앱이 최상위 단위이고 계정마다 여러개를 가질 수 있다.
> - 비즈유닛은 앱에 속한다. 비즈유닛간의 연계성은 없다.
> - 비즈유닛은 한개의 Endpoint를 갖는다.
> - 오퍼레이터는 통신의 기본단위 개념이다. 팀에 속하며 비즈유닛에 바인딩 시킬 수 있다.
> - 비즈유닛 안에서 오퍼레이터는 여러개 존재할 수 있으며 오퍼레이터 간 릴레이를 설정할 수 있다.
> - 오퍼레이터의 속성에 통신할 엔드포인트 및 Request/Response 변수를 지정 할 수 있다.
> - 앱, 비즈유닛, 오퍼레이터의 정보값은 DB에 있고, 이를 조합해 Redis에 메타데이터를 생성해 갖고 있다.
> - 비유닛을 저장하면 디비와 Redis의 정보를 갱신하고, 빌드하면 해당 메타데이터를 통해 파일을 생성한다.
> - CodeDeploy를 통해 컨슈머의 서버에 배포한다.
> - 생성된 비즈유닛이 호출될때 S3에 로깅파일을 업로드 한다.

## 개발 기능
> - 비즈유닛에 오퍼레이터를 바인딩하고 오퍼레이터 간의 변수 연계 지원
> - 비즈유닛 파일 생성 기능
> - 오퍼레이터 JSON 형식 지원
> - 오퍼레이터 통신형식 형식 지원
> - 오퍼레이터 보안프로토콜 적용
> - 오퍼레이터 바인딩시 Authorization 적용
> - ALT 컨트롤 기능 (오퍼레이터 switch case)
> - PHP Class, route 파일 생성 및 배포 기능
> - Async
> - Loop (예정)
> - 오퍼레이터의 변수 require field 기능
